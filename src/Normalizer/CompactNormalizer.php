<?php

declare(strict_types=1);

namespace VerbaGuard\Normalizer;

final class CompactNormalizer implements Normalizer
{
    public function normalize(string $text): string
    {
        if ($text === '') {
            return $text;
        }

        return (string) preg_replace('/[\s\p{P}\p{S}]+/u', '', $text);
    }
}
