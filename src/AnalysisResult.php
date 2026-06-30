<?php

declare(strict_types=1);

namespace VerbaGuard;

final class AnalysisResult
{
    /**
     * @param list<ProfanityMatch> $matches
     */
    public function __construct(
        private readonly string $original,
        private readonly array $matches,
        private readonly int $score,
        private readonly string $severity,
    ) {
    }

    public function hasProfanity(): bool
    {
        return $this->matches !== [];
    }

    public function score(): int
    {
        return $this->score;
    }

    public function severity(): string
    {
        return $this->severity;
    }

    /**
     * @return list<ProfanityMatch>
     */
    public function matches(): array
    {
        return $this->matches;
    }

    public function masked(string $mask = '*'): string
    {
        if ($this->matches === []) {
            return $this->original;
        }

        $ranges = [];

        foreach ($this->matches as $match) {
            $ranges[] = [$match->start(), $match->length()];
        }

        usort($ranges, static fn (array $a, array $b): int => $a[0] <=> $b[0]);

        $merged = [];
        foreach ($ranges as [$start, $length]) {
            $end = $start + $length;

            if ($merged === []) {
                $merged[] = [$start, $end];
                continue;
            }

            [$lastStart, $lastEnd] = $merged[array_key_last($merged)];

            if ($start <= $lastEnd) {
                $merged[array_key_last($merged)] = [$lastStart, max($lastEnd, $end)];
            } else {
                $merged[] = [$start, $end];
            }
        }

        $result = '';
        $cursor = 0;
        $byteLength = strlen($this->original);

        foreach ($merged as [$start, $end]) {
            if ($cursor < $start) {
                $result .= substr($this->original, $cursor, $start - $cursor);
            }

            $segment = substr($this->original, $start, $end - $start);
            $result .= str_repeat($mask, mb_strlen($segment, 'UTF-8'));
            $cursor = $end;
        }

        if ($cursor < $byteLength) {
            $result .= substr($this->original, $cursor);
        }

        return $result;
    }
}
