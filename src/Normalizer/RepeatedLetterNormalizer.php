<?php

declare(strict_types=1);

namespace VerbaGuard\Normalizer;

final class RepeatedLetterNormalizer implements Normalizer
{
    public function normalize(string $text): string
    {
        if ($text === '') {
            return $text;
        }

        return (string) preg_replace('/(.)\1{2,}/u', '$1', $text);
    }
}
