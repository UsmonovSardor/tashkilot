<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\EscrowTransaction;
use App\Models\Payment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use Stripe\StripeClient;

/**
 * Escrow Payment State Machine
 *
 * States:  holding → releasing → released
 *          holding → refunding → refunded
 *          holding|releasing → disputed → resolved
 *
 * Rules:
 * - Auto-release 48 hours after event completion (if no dispute)
 * - Platform fee: 15% deducted before provider payout
 * - Disputes freeze the escrow until admin resolution
 * - Partial refund supported (e.g., cancellation within 24h → 50%)
 */
class EscrowService
{
    private const PLATFORM_FEE_RATE  = 0.15;
    private const AUTO_RELEASE_HOURS = 48;

    // Cancellation refund policy: hours_before_event => refund_percentage
    private const CANCELLATION_POLICY = [
        72  => 1.00,   // >72h before → 100% refund
        24  => 0.50,   // 24-72h before → 50% refund
        0   => 0.00,   // <24h before → no refund
    ];

    public function __construct(
        private readonly StripeClient $stripe,
    ) {}

    // ─────────────────────────── CAPTURE ────────────────────────────

    /**
     * Step 1: Client confirms booking → capture payment and hold in escrow.
     */
    public function holdFunds(Booking $booking, string $paymentIntentId): EscrowTransaction
    {
        return DB::transaction(function () use ($booking, $paymentIntentId) {
            // Confirm with Stripe (funds already captured to platform)
            $pi = $this->stripe->paymentIntents->capture($paymentIntentId);

            $payment = Payment::create([
                'booking_id'          => $booking->id,
                'payer_id'            => $booking->client_id,
                'amount'              => $booking->total_amount,
                'currency'            => $booking->currency,
                'status'              => 'captured',
                'payment_method'      => 'stripe',
                'gateway_payment_id'  => $pi->id,
                'gateway_metadata'    => ['pi_status' => $pi->status],
                'captured_at'         => now(),
            ]);

            $platformFee    = round($booking->total_amount * self::PLATFORM_FEE_RATE, 2);
            $providerPayout = round($booking->total_amount - $platformFee, 2);

            $escrow = EscrowTransaction::create([
                'payment_id'           => $payment->id,
                'booking_id'           => $booking->id,
                'provider_id'          => $this->resolveProviderId($booking),
                'held_amount'          => $booking->total_amount,
                'platform_fee'         => $platformFee,
                'provider_payout'      => $providerPayout,
                'state'                => 'holding',
                'held_at'              => now(),
                'release_scheduled_at' => Carbon::parse($booking->ends_at)->addHours(self::AUTO_RELEASE_HOURS),
            ]);

            $booking->update(['status' => 'confirmed']);

            Log::info('Escrow holding', [
                'booking_id' => $booking->id,
                'amount'     => $booking->total_amount,
                'escrow_id'  => $escrow->id,
            ]);

            return $escrow;
        });
    }

    // ─────────────────────────── RELEASE ────────────────────────────

    /**
     * Step 2a: Event completed successfully → initiate payout to provider.
     * Can be triggered by client confirmation or auto-release job.
     */
    public function releaseFunds(EscrowTransaction $escrow, string $reason = 'client_confirmed'): EscrowTransaction
    {
        $this->assertState($escrow, ['holding'], 'release');

        return DB::transaction(function () use ($escrow, $reason) {
            $escrow->update(['state' => 'releasing']);

            try {
                $transfer = $this->stripe->transfers->create([
                    'amount'      => (int) ($escrow->provider_payout * 100), // cents
                    'currency'    => 'usd',
                    'destination' => $this->getProviderStripeAccountId($escrow->provider_id),
                    'metadata'    => [
                        'booking_id' => $escrow->booking_id,
                        'reason'     => $reason,
                        'escrow_id'  => $escrow->id,
                    ],
                ]);

                $escrow->update([
                    'state'              => 'released',
                    'released_at'        => now(),
                    'stripe_transfer_id' => $transfer->id,
                ]);

                $escrow->booking->update(['status' => 'completed']);

                Log::info('Escrow released', [
                    'escrow_id'   => $escrow->id,
                    'payout'      => $escrow->provider_payout,
                    'transfer_id' => $transfer->id,
                ]);
            } catch (\Exception $e) {
                $escrow->update(['state' => 'holding']); // roll back state
                Log::error('Escrow release failed', ['error' => $e->getMessage()]);
                throw $e;
            }

            return $escrow->fresh();
        });
    }

    // ─────────────────────────── REFUND ────────────────────────────

    /**
     * Step 2b: Cancellation → compute refund amount per policy and refund client.
     */
    public function refundFunds(EscrowTransaction $escrow, string $cancelledBy = 'client'): array
    {
        $this->assertState($escrow, ['holding'], 'refund');

        $booking       = $escrow->booking;
        $refundPercent = $this->computeRefundPercent($booking, $cancelledBy);
        $refundAmount  = round($escrow->held_amount * $refundPercent, 2);

        return DB::transaction(function () use ($escrow, $booking, $refundAmount, $cancelledBy, $refundPercent) {
            $escrow->update(['state' => 'refunding']);

            try {
                $refundData = ['payment_intent' => $escrow->payment->gateway_payment_id];

                if ($refundAmount < $escrow->held_amount) {
                    $refundData['amount'] = (int) ($refundAmount * 100); // partial refund in cents
                }

                $stripeRefund = $this->stripe->refunds->create($refundData);

                $escrow->update([
                    'state'           => 'refunded',
                    'refunded_at'     => now(),
                    'stripe_refund_id'=> $stripeRefund->id,
                    'admin_notes'     => "Refund {$refundPercent*100}% — cancelled by {$cancelledBy}",
                ]);

                $bookingStatus = $cancelledBy === 'client' ? 'cancelled_client' : 'cancelled_provider';
                $booking->update(['status' => $bookingStatus]);

                Log::info('Escrow refunded', [
                    'escrow_id'  => $escrow->id,
                    'refund_pct' => $refundPercent,
                    'amount'     => $refundAmount,
                ]);

                return [
                    'refund_amount'   => $refundAmount,
                    'refund_percent'  => $refundPercent * 100,
                    'stripe_refund_id'=> $stripeRefund->id,
                ];
            } catch (\Exception $e) {
                $escrow->update(['state' => 'holding']);
                throw $e;
            }
        });
    }

    // ─────────────────────────── DISPUTE ────────────────────────────

    /**
     * Either party opens a dispute → freeze escrow, alert admin.
     */
    public function openDispute(EscrowTransaction $escrow, User $openedBy, string $reason): EscrowTransaction
    {
        $this->assertState($escrow, ['holding', 'releasing'], 'dispute');

        $escrow->update([
            'state'       => 'disputed',
            'admin_notes' => "Dispute opened by user #{$openedBy->id}: {$reason}",
        ]);

        $escrow->booking->update(['status' => 'disputed']);

        Log::warning('Escrow disputed', [
            'escrow_id' => $escrow->id,
            'opened_by' => $openedBy->id,
            'reason'    => $reason,
        ]);

        return $escrow->fresh();
    }

    /**
     * Admin resolves dispute — can choose to release or refund.
     */
    public function resolveDispute(
        EscrowTransaction $escrow,
        string            $resolution,  // 'release_to_provider' | 'refund_to_client' | 'split'
        float             $clientRefundPercent = 0.0,
        string            $adminNotes = '',
    ): EscrowTransaction {
        $this->assertState($escrow, ['disputed'], 'resolve');

        $escrow->update(['state' => 'resolved', 'admin_notes' => $adminNotes]);

        match ($resolution) {
            'release_to_provider' => $this->releaseFunds($escrow, 'admin_dispute_resolved'),
            'refund_to_client'    => $this->refundFunds($escrow, 'admin_dispute_resolved'),
            'split'               => $this->processSplit($escrow, $clientRefundPercent),
            default               => throw new RuntimeException("Unknown resolution: {$resolution}"),
        };

        return $escrow->fresh();
    }

    // ─────────────────────────── HELPERS ────────────────────────────

    private function assertState(EscrowTransaction $escrow, array $allowedStates, string $action): void
    {
        if (!in_array($escrow->state, $allowedStates, true)) {
            throw new RuntimeException(
                "Cannot {$action} escrow #{$escrow->id}: state is '{$escrow->state}', expected one of [" . implode(', ', $allowedStates) . ']'
            );
        }
    }

    private function computeRefundPercent(Booking $booking, string $cancelledBy): float
    {
        // Provider cancellation → always full refund to client
        if ($cancelledBy === 'provider') {
            return 1.0;
        }

        $hoursUntilEvent = now()->diffInHours(Carbon::parse($booking->starts_at), false);

        if ($hoursUntilEvent <= 0) {
            return self::CANCELLATION_POLICY[0];
        }

        foreach (self::CANCELLATION_POLICY as $hours => $percent) {
            if ($hoursUntilEvent >= $hours) {
                return $percent;
            }
        }

        return 0.0;
    }

    private function resolveProviderId(Booking $booking): int
    {
        return match ($booking->booking_type) {
            'companion' => $booking->bookable->user_id,
            'venue'     => 1, // venue owner admin account — replace with actual FK
            'fleet'     => $booking->driver->user_id,
            default     => 1,
        };
    }

    private function getProviderStripeAccountId(int $userId): string
    {
        // In production: User::find($userId)->stripe_account_id
        return 'acct_placeholder_' . $userId;
    }

    private function processSplit(EscrowTransaction $escrow, float $clientRefundPercent): void
    {
        $clientRefund  = round($escrow->held_amount * $clientRefundPercent, 2);
        $providerShare = round($escrow->held_amount - $clientRefund, 2) * (1 - self::PLATFORM_FEE_RATE);

        if ($clientRefund > 0) {
            $this->stripe->refunds->create([
                'payment_intent' => $escrow->payment->gateway_payment_id,
                'amount'         => (int) ($clientRefund * 100),
            ]);
        }

        if ($providerShare > 0) {
            $this->stripe->transfers->create([
                'amount'      => (int) ($providerShare * 100),
                'currency'    => 'usd',
                'destination' => $this->getProviderStripeAccountId($escrow->provider_id),
            ]);
        }
    }
}
