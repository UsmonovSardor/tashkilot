<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CompanionResource;
use App\Models\Booking;
use App\Models\Companion;
use App\Services\BookingService;
use App\Services\CompanionMatchingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CompanionController extends Controller
{
    public function __construct(
        private readonly CompanionMatchingService $matchingService,
        private readonly BookingService           $bookingService,
    ) {}

    /**
     * GET /companions
     * Advanced filtering: gender, language, skill, price range, event type.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $viewerGender = $request->user()?->profile?->gender ?? 'male';
        $oppositeGender = $viewerGender === 'male' ? 'female' : 'male';

        $companions = Companion::with(['user.profile', 'languages', 'skills', 'photos'])
            ->whereHas('user.profile', fn($q) => $q->where('gender', $oppositeGender))
            ->where('is_verified', true)
            ->when($request->language, fn($q, $lang) =>
                $q->whereHas('languages', fn($lq) => $lq->where('language', 'like', "%{$lang}%"))
            )
            ->when($request->skill_category, fn($q, $cat) =>
                $q->whereHas('skills', fn($sq) => $sq->where('category', $cat))
            )
            ->when($request->event_type, fn($q, $type) =>
                $q->whereJsonContains('event_types', $type)
            )
            ->when($request->max_hourly_rate, fn($q, $max) =>
                $q->where('hourly_rate', '<=', $max)
            )
            ->when($request->min_rating, fn($q, $min) =>
                $q->where('rating', '>=', $min)
            )
            ->when($request->availability === 'available', fn($q) =>
                $q->where('availability_status', 'available')
            )
            ->orderBy($request->sort_by ?? 'rating', $request->sort_dir ?? 'desc')
            ->paginate($request->per_page ?? 12);

        return CompanionResource::collection($companions);
    }

    /**
     * GET /companions/ai-match
     * Returns AI-ranked companions for a specific event type.
     */
    public function aiMatch(Request $request): JsonResponse
    {
        $request->validate([
            'event_type' => 'required|string',
            'languages'  => 'nullable|array',
            'languages.*'=> 'string',
        ]);

        $clientId     = $request->user()?->id ?? 0;
        $viewerGender = $request->user()?->profile?->gender ?? 'male';

        $matches = $this->matchingService->findMatches(
            clientId         : $clientId,
            eventType        : $request->event_type,
            requiredLanguages: $request->languages ?? [],
            viewerGender     : $viewerGender,
            limit            : 20,
        );

        return response()->json([
            'data'       => CompanionResource::collection($matches),
            'event_type' => $request->event_type,
            'total'      => $matches->count(),
        ]);
    }

    /**
     * GET /companions/{id}
     * Full profile — photos are blurred unless client has active booking.
     */
    public function show(Request $request, int $id): CompanionResource
    {
        $companion = Companion::with(['user.profile', 'languages', 'skills', 'photos'])->findOrFail($id);

        // Reveal unblurred photos only for confirmed or completed bookings
        $hasActiveBooking = $request->user() && Booking::where('client_id', $request->user()->id)
            ->whereHasMorph('bookable', Companion::class, fn($q) => $q->where('id', $id))
            ->whereIn('status', ['confirmed', 'in_progress', 'completed'])
            ->exists();

        $companion->setAttribute('reveal_photos', $hasActiveBooking);

        return new CompanionResource($companion);
    }

    /**
     * POST /companions/{id}/book
     */
    public function book(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'starts_at'       => 'required|date|after:now',
            'duration_hours'  => 'required|integer|min:1|max:12',
            'event_type'      => 'required|string',
            'special_requests'=> 'nullable|string|max:1000',
            'addon_ids'       => 'nullable|array',
        ]);

        $companion = Companion::where('availability_status', 'available')->findOrFail($id);
        $booking   = $this->bookingService->createCompanionBooking($request->user(), $companion, $request->validated());

        return response()->json(['data' => $booking, 'message' => 'Booking created. Proceed to payment.'], 201);
    }

    public function verify(int $id): JsonResponse
    {
        $companion = Companion::findOrFail($id);
        $companion->update(['is_verified' => true, 'verified_at' => now()]);
        return response()->json(['message' => 'Companion verified.']);
    }

    public function feature(int $id): JsonResponse
    {
        $companion = Companion::findOrFail($id);
        $companion->update(['is_featured' => !$companion->is_featured]);
        return response()->json(['is_featured' => $companion->fresh()->is_featured]);
    }
}
