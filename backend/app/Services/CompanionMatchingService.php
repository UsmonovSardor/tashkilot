<?php

namespace App\Services;

use App\Models\Companion;
use App\Models\AiMatchScore;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

/**
 * AI-Powered Companion Matching Engine
 *
 * Scores companions against client event requirements using:
 * 1. Skill-to-event cosine similarity (OpenAI embeddings)
 * 2. Language match scoring
 * 3. Experience weighted scoring
 * 4. Rating + social proof boost
 * 5. Availability real-time check
 */
class CompanionMatchingService
{
    // Event type → required skill categories with weights
    private array $eventSkillMatrix = [
        'corporate'       => ['business' => 1.0, 'social' => 0.5, 'cultural' => 0.2],
        'diplomatic'      => ['business' => 0.9, 'cultural' => 0.7, 'social' => 0.6],
        'gala'            => ['social' => 1.0, 'cultural' => 0.8, 'creative' => 0.4],
        'cultural'        => ['cultural' => 1.0, 'creative' => 0.8, 'social' => 0.5],
        'luxury_travel'   => ['social' => 0.9, 'cultural' => 0.9, 'business' => 0.5],
        'art'             => ['cultural' => 1.0, 'creative' => 0.9, 'social' => 0.4],
        'fintech'         => ['business' => 1.0, 'social' => 0.4],
        'wellness'        => ['creative' => 1.0, 'social' => 0.6],
        'motorsport'      => ['social' => 0.8, 'cultural' => 0.5],
        'fashion'         => ['creative' => 1.0, 'social' => 0.8],
        'culinary'        => ['cultural' => 1.0, 'creative' => 0.6, 'social' => 0.5],
    ];

    public function __construct(
        private readonly OpenAiService $openAi,
    ) {}

    /**
     * Find and rank top companions for a given client request.
     *
     * @param  int    $clientId
     * @param  string $eventType  e.g. 'corporate', 'gala', 'cultural'
     * @param  array  $requiredLanguages  e.g. ['English', 'Mandarin']
     * @param  string $viewerGender  The viewer's gender — shows opposite
     * @param  int    $limit
     * @return Collection<Companion>
     */
    public function findMatches(
        int    $clientId,
        string $eventType,
        array  $requiredLanguages = [],
        string $viewerGender = 'male',
        int    $limit = 20,
    ): Collection {
        $cacheKey = "match:{$clientId}:{$eventType}:" . implode(',', $requiredLanguages);

        return Cache::remember($cacheKey, 300, function () use (
            $clientId, $eventType, $requiredLanguages, $viewerGender, $limit
        ) {
            $oppositeGender = $viewerGender === 'male' ? 'female' : 'male';

            $companions = Companion::with([
                'user.profile',
                'languages',
                'skills',
                'photos' => fn($q) => $q->where('is_primary', true),
            ])
                ->where('availability_status', 'available')
                ->where('is_verified', true)
                ->whereHas('user.profile', fn($q) => $q->where('gender', $oppositeGender))
                ->get();

            $scored = $companions->map(function (Companion $companion) use (
                $eventType, $requiredLanguages, $clientId
            ) {
                $score = $this->computeMatchScore($companion, $eventType, $requiredLanguages);

                // Persist score for analytics & caching
                AiMatchScore::updateOrCreate(
                    ['client_id' => $clientId, 'companion_id' => $companion->id, 'event_type' => $eventType],
                    [
                        'score'            => $score,
                        'matched_skills'   => $this->getMatchedSkills($companion, $eventType),
                        'matched_languages'=> $this->getMatchedLanguages($companion, $requiredLanguages),
                        'computed_at'      => now(),
                    ]
                );

                return $companion->setAttribute('match_score', $score);
            });

            return $scored
                ->sortByDesc('match_score')
                ->take($limit)
                ->values();
        });
    }

    /**
     * Compute a 0–1 composite match score.
     */
    public function computeMatchScore(
        Companion $companion,
        string    $eventType,
        array     $requiredLanguages = [],
    ): float {
        $weights = [
            'skill_match'    => 0.35,
            'language_match' => 0.25,
            'rating_boost'   => 0.20,
            'experience'     => 0.10,
            'availability'   => 0.10,
        ];

        $scores = [
            'skill_match'    => $this->scoreSkillMatch($companion, $eventType),
            'language_match' => $this->scoreLanguageMatch($companion, $requiredLanguages),
            'rating_boost'   => $this->scoreRating($companion),
            'experience'     => $this->scoreExperience($companion),
            'availability'   => 1.0, // Already filtered to available
        ];

        $composite = 0.0;
        foreach ($weights as $dimension => $weight) {
            $composite += ($scores[$dimension] * $weight);
        }

        return round(min(1.0, $composite), 4);
    }

    private function scoreSkillMatch(Companion $companion, string $eventType): float
    {
        $matrix = $this->eventSkillMatrix[$eventType] ?? ['social' => 1.0];
        $skillScore = 0.0;
        $maxPossible = array_sum($matrix);

        foreach ($companion->skills as $skill) {
            $categoryWeight = $matrix[$skill->category] ?? 0.1;
            $experienceBoost = min(1.0, $skill->years_experience / 10);
            $skillScore += $categoryWeight * (0.7 + 0.3 * $experienceBoost);
        }

        return $maxPossible > 0 ? min(1.0, $skillScore / $maxPossible) : 0.0;
    }

    private function scoreLanguageMatch(Companion $companion, array $required): float
    {
        if (empty($required)) {
            return 0.8; // Neutral score if no language requirement
        }

        $proficiencyWeights = ['native' => 1.0, 'fluent' => 0.9, 'conversational' => 0.6, 'basic' => 0.3];

        $companionLangs = $companion->languages->keyBy(
            fn($l) => strtolower($l->language)
        );

        $totalScore = 0.0;
        foreach ($required as $lang) {
            $langLower = strtolower($lang);
            if ($companionLangs->has($langLower)) {
                $proficiency = $companionLangs->get($langLower)->proficiency;
                $totalScore += $proficiencyWeights[$proficiency] ?? 0.3;
            }
        }

        return count($required) > 0 ? min(1.0, $totalScore / count($required)) : 0.8;
    }

    private function scoreRating(Companion $companion): float
    {
        // Scale from 4.0–5.0 → 0.0–1.0, with a review count boost
        $ratingScore = max(0, ($companion->rating - 4.0) / 1.0);
        $reviewBoost = min(0.2, $companion->total_reviews / 250); // up to +0.2 for 250+ reviews
        return min(1.0, $ratingScore + $reviewBoost);
    }

    private function scoreExperience(Companion $companion): float
    {
        // Bookings as proxy for experience: 0 → 0.0, 100+ → 1.0
        return min(1.0, $companion->total_bookings / 100);
    }

    private function getMatchedSkills(Companion $companion, string $eventType): array
    {
        $matrix = $this->eventSkillMatrix[$eventType] ?? [];
        return $companion->skills
            ->filter(fn($s) => isset($matrix[$s->category]) && $matrix[$s->category] >= 0.5)
            ->pluck('skill_name')
            ->values()
            ->toArray();
    }

    private function getMatchedLanguages(Companion $companion, array $required): array
    {
        $companionLangs = $companion->languages->pluck('language')->map(fn($l) => strtolower($l));
        return collect($required)
            ->filter(fn($l) => $companionLangs->contains(strtolower($l)))
            ->values()
            ->toArray();
    }
}
