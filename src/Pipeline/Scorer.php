<?php

declare(strict_types=1);

namespace VerbaGuard\Pipeline;

use VerbaGuard\AnalysisResult;
use VerbaGuard\Contracts\LanguageProfile;
use VerbaGuard\ProfanityMatch;
use VerbaGuard\Severity;

final class Scorer
{
    /**
     * @param list<ProfanityMatch> $matches
     *
     * @return array{score: int, severity: string}
     */
    public function score(array $matches): array
    {
        if ($matches === []) {
            return [
                'score' => 0,
                'severity' => Severity::Clean->value,
            ];
        }

        $score = 0;
        $maxSeverity = Severity::Clean;

        foreach ($matches as $match) {
            $severity = Severity::fromString($match->severity());
            $score += $severity->scoreValue();
            $maxSeverity = Severity::max($maxSeverity, $severity);
        }

        return [
            'score' => $score,
            'severity' => $maxSeverity->value,
        ];
    }
}
