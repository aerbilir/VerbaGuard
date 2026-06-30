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
    public function match(string $original): array
    {
        if ($original === '') {
            return [];
        }

        $segments = TextSegments::from($original);

        return [
            ...$this->matchExactTokens($original),
            ...$this->matchAcrossSeparators($original, $segments),
        ];
    }

    /**
     * @return list<ProfanityMatch>
     */
    private function matchExactTokens(string $original): array
    {
        $matches = [];

        if (preg_match_all('/[\p{L}\p{N}@$!]+/u', $original, $wordMatches, PREG_OFFSET_CAPTURE) === false) {
            return $matches;
        }

        foreach ($wordMatches[0] as [$word, $byteOffset]) {
            $normalizedWord = $this->normalization->normalize($word);
            $entry = $this->dictionary->find($normalizedWord);

            if ($entry === null) {
                continue;
            }

            $matches[] = $this->createMatch(
                $word,
                $normalizedWord,
                $entry,
                $byteOffset,
                strlen($word),
            );
        }

        return $matches;
    }

    /**
     * @return list<ProfanityMatch>
     */
    private function matchAcrossSeparators(string $original, TextSegments $segments): array
    {
        $matches = [];
        $runs = $segments->runs();

        foreach ($this->spelledChains($runs) as $chainRunIndices) {
            $letters = '';

            foreach ($chainRunIndices as $runIndex) {
                $letters .= $runs[$runIndex]->text();
            }

            $normalized = $this->normalization->normalize($letters);
            $entry = $this->dictionary->find($normalized);

            if ($entry === null) {
                continue;
            }

            $firstRunIndex = $chainRunIndices[0];
            $lastRunIndex = $chainRunIndices[array_key_last($chainRunIndices)];
            $byteStart = $runs[$firstRunIndex]->byteStart();
            $byteEnd = $runs[$lastRunIndex]->byteEnd();
            $matchedOriginal = substr($original, $byteStart, $byteEnd - $byteStart);

            $matches[] = $this->createMatch(
                $matchedOriginal,
                $normalized,
                $entry,
                $byteStart,
                $byteEnd - $byteStart,
            );
        }

        return $matches;
    }

    /**
     * @param list<SegmentRun> $runs
     *
     * @return list<list<int>>
     */
    private function spelledChains(array $runs): array
    {
        $chains = [];
        $current = [];

        foreach ($runs as $index => $run) {
            if (! $run->isLetter()) {
                continue;
            }

            $isMultiChar = mb_strlen($run->text(), 'UTF-8') >= 2;

            if ($isMultiChar && count($current) >= 2) {
                $chains[] = $current;
                $current = [];
            }

            $current[] = $index;

            if ($isMultiChar && count($current) >= 2) {
                $chains[] = $current;
                $current = [];
            }
        }

        if (count($current) >= 2) {
            $chains[] = $current;
        }

        return $chains;
    }

    private function createMatch(
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
