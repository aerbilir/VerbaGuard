<?php

declare(strict_types=1);

namespace VerbaGuard\Pipeline;

use VerbaGuard\AnalysisResult;
use VerbaGuard\Contracts\LanguageProfile;
use VerbaGuard\ProfanityMatch;

final class Pipeline
{
    /** @var list<LanguageProfile> */
    private array $profiles;

    /**
     * @param list<LanguageProfile> $profiles
     */
    public function __construct(array $profiles)
    {
        $this->profiles = $profiles;
    }

    public function analyze(string $text): AnalysisResult
    {
        if ($text === '') {
            return new AnalysisResult($text, [], 0, 'clean');
        }

        $matches = [];

        foreach ($this->profiles as $profile) {
            $matches = [...$matches, ...$this->analyzeWithProfile($text, $profile)];
        }

        $matches = $this->deduplicateMatches($matches);
        $scored = (new Scorer())->score($matches);

        return new AnalysisResult(
            $text,
            $matches,
            $scored['score'],
            $scored['severity'],
        );
    }

    /**
     * @return list<ProfanityMatch>
     */
    private function analyzeWithProfile(string $text, LanguageProfile $profile): array
    {
        $normalization = new NormalizationPipeline($profile->normalizers());
        $matcher = new Matcher($profile->dictionary(), $profile->code(), $normalization);

        return $matcher->match($text);
    }

    /**
     * @param list<ProfanityMatch> $matches
     *
     * @return list<ProfanityMatch>
     */
    private function deduplicateMatches(array $matches): array
    {
        if ($matches === []) {
            return [];
        }

        usort(
            $matches,
            static fn (ProfanityMatch $a, ProfanityMatch $b): int => $a->start() <=> $b->start()
                ?: $b->length() <=> $a->length(),
        );

        $deduplicated = [];

        foreach ($matches as $match) {
            $overlaps = false;

            foreach ($deduplicated as $existing) {
                $matchEnd = $match->start() + $match->length();
                $existingEnd = $existing->start() + $existing->length();

                if ($match->start() < $existingEnd && $matchEnd > $existing->start()) {
                    $overlaps = true;
                    break;
                }
            }

            if (! $overlaps) {
                $deduplicated[] = $match;
            }
        }

        return $deduplicated;
    }
}
