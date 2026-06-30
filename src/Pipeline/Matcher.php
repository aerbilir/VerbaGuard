<?php

declare(strict_types=1);

namespace VerbaGuard\Pipeline;

use VerbaGuard\Dictionary\Dictionary;
use VerbaGuard\Dictionary\Entry;
use VerbaGuard\ProfanityMatch;

final class Matcher
{
    public function __construct(
        private readonly Dictionary $dictionary,
        private readonly string $language,
        private readonly NormalizationPipeline $normalization,
    ) {
    }

    /**
     * @return list<ProfanityMatch>
     */
    public function matchWordLevel(string $original, string $normalized): array
    {
        $matches = [];

        if (preg_match_all('/\p{L}[\p{L}\p{N}]*/u', $original, $wordMatches, PREG_OFFSET_CAPTURE) !== false) {
            foreach ($wordMatches[0] as [$word, $byteOffset]) {
                $normalizedWord = $this->normalizeWord($word);

                $entry = $this->dictionary->find($normalizedWord);

                if ($entry !== null) {
                    $matches[] = $this->createMatch(
                        $original,
                        $word,
                        $normalizedWord,
                        $entry,
                        $byteOffset,
                        strlen($word),
                    );
                }
            }
        }

        foreach ($this->dictionary->entries() as $entry) {
            $term = $entry->normalized;

            if ($term === '') {
                continue;
            }

            $offset = 0;

            while (($position = mb_strpos($normalized, $term, $offset, 'UTF-8')) !== false) {
                if ($this->hasWordBoundary($normalized, $position, mb_strlen($term, 'UTF-8'))) {
                    $byteStart = $this->byteOffsetAt($normalized, $position);
                    $byteLength = strlen(mb_substr($normalized, $position, mb_strlen($term, 'UTF-8'), 'UTF-8'));
                    $matchedOriginal = substr($original, $byteStart, $byteLength);
                    $matchedNormalized = mb_substr($normalized, $position, mb_strlen($term, 'UTF-8'), 'UTF-8');

                    if (! $this->hasExistingMatch($matches, $byteStart, $byteLength)) {
                        $matches[] = $this->createMatch(
                            $original,
                            $matchedOriginal,
                            $matchedNormalized,
                            $entry,
                            $byteStart,
                            $byteLength,
                        );
                    }
                }

                $offset = $position + 1;
            }
        }

        return $matches;
    }

    /**
     * @return list<ProfanityMatch>
     */
    public function matchCompact(string $original, string $normalized, string $compact): array
    {
        $matches = [];
        $letterPositions = $this->letterPositions($original);

        if ($letterPositions === []) {
            return $matches;
        }

        foreach ($this->dictionary->entries() as $entry) {
            $term = $entry->normalized;
            $offset = 0;

            while (($position = strpos($compact, $term, $offset)) !== false) {
                $termLength = strlen($term);
                $startIndex = $position;
                $endIndex = $position + $termLength - 1;

                $originalStart = $letterPositions[$this->mapCompactIndex($startIndex, count($letterPositions), strlen($compact))];
                $originalEnd = $letterPositions[$this->mapCompactIndex($endIndex, count($letterPositions), strlen($compact))];
                $byteStart = $originalStart;
                $byteEnd = $originalEnd + strlen(mb_substr($original, $originalEnd, 1, 'UTF-8'));
                $byteLength = $byteEnd - $byteStart;

                if (! $this->hasExistingMatch($matches, $byteStart, $byteLength)) {
                    $matchedOriginal = substr($original, $byteStart, $byteLength);
                    $matchedNormalized = substr($compact, $position, $termLength);

                    $matches[] = $this->createMatch(
                        $original,
                        $matchedOriginal,
                        $matchedNormalized,
                        $entry,
                        $byteStart,
                        $byteLength,
                    );
                }

                $offset = $position + 1;
            }
        }

        return $matches;
    }

    private function normalizeWord(string $word): string
    {
        return $this->normalization->normalize($word);
    }

    private function hasWordBoundary(string $text, int $charOffset, int $charLength): bool
    {
        $before = $charOffset > 0 ? mb_substr($text, $charOffset - 1, 1, 'UTF-8') : '';
        $afterOffset = $charOffset + $charLength;
        $after = $afterOffset < mb_strlen($text, 'UTF-8')
            ? mb_substr($text, $afterOffset, 1, 'UTF-8')
            : '';

        return ! $this->isAlphaNumeric($before) && ! $this->isAlphaNumeric($after);
    }

    private function isAlphaNumeric(string $char): bool
    {
        if ($char === '') {
            return false;
        }

        return (bool) preg_match('/[\p{L}\p{N}]/u', $char);
    }

    private function byteOffsetAt(string $text, int $charOffset): int
    {
        return strlen(mb_substr($text, 0, $charOffset, 'UTF-8'));
    }

    /**
     * @param list<ProfanityMatch> $matches
     */
    private function hasExistingMatch(array $matches, int $start, int $length): bool
    {
        foreach ($matches as $match) {
            $matchEnd = $match->start() + $match->length();
            $end = $start + $length;

            if ($start < $matchEnd && $end > $match->start()) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return list<int>
     */
    private function letterPositions(string $text): array
    {
        $positions = [];
        $length = mb_strlen($text, 'UTF-8');

        for ($i = 0; $i < $length; $i++) {
            $char = mb_substr($text, $i, 1, 'UTF-8');
            $byteOffset = strlen(mb_substr($text, 0, $i, 'UTF-8'));

            if ($this->isAlphaNumeric($char)) {
                $positions[] = $byteOffset;
            }
        }

        return $positions;
    }

    private function mapCompactIndex(int $compactIndex, int $letterCount, int $compactLength): int
    {
        if ($letterCount === 0) {
            return 0;
        }

        if ($letterCount === $compactLength) {
            return min($compactIndex, $letterCount - 1);
        }

        if ($letterCount <= 1 || $compactLength <= 1) {
            return 0;
        }

        $ratio = $compactIndex / max($compactLength - 1, 1);

        return (int) round($ratio * ($letterCount - 1));
    }

    private function createMatch(
        string $original,
        string $matchedOriginal,
        string $matchedNormalized,
        Entry $entry,
        int $start,
        int $length,
    ): ProfanityMatch {
        return new ProfanityMatch(
            $matchedOriginal,
            $matchedNormalized,
            $entry->term,
            $this->language,
            $entry->category,
            $entry->severity,
            $start,
            $length,
        );
    }
}
