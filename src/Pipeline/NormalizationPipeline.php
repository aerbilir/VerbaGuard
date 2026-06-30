<?php

declare(strict_types=1);

namespace VerbaGuard\Pipeline;

use VerbaGuard\Normalizer\CompactNormalizer;
use VerbaGuard\Normalizer\LeetspeakNormalizer;
use VerbaGuard\Normalizer\Normalizer;
use VerbaGuard\Normalizer\RepeatedLetterNormalizer;
use VerbaGuard\Normalizer\UnicodeNormalizer;

final class NormalizationPipeline
{
    /** @var list<Normalizer> */
    private array $globalNormalizers;

  /** @var list<Normalizer> */
    private array $profileNormalizers;

    /**
     * @param list<Normalizer> $profileNormalizers
     */
    public function __construct(array $profileNormalizers)
    {
        $this->globalNormalizers = [
            new UnicodeNormalizer(),
            new LeetspeakNormalizer(),
            new RepeatedLetterNormalizer(),
        ];
        $this->profileNormalizers = $profileNormalizers;
    }

    public function normalize(string $text): string
    {
        foreach ($this->allNormalizers() as $normalizer) {
            $text = $normalizer->normalize($text);
        }

        return $text;
    }

    public function compact(string $text): string
    {
        return (new CompactNormalizer())->normalize($this->normalize($text));
    }

    /**
     * @return list<Normalizer>
     */
    private function allNormalizers(): array
    {
        return [
            ...[$this->globalNormalizers[0]],
            ...$this->profileNormalizers,
            ...array_slice($this->globalNormalizers, 1),
        ];
    }
}
