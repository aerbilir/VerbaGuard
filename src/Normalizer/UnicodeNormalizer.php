<?php

declare(strict_types=1);

namespace VerbaGuard\Normalizer;

final class UnicodeNormalizer implements Normalizer
{
    public function normalize(string $text): string
    {
        if ($text === '') {
            return $text;
        }

        if (class_exists(\Normalizer::class) && \Normalizer::isNormalized($text, \Normalizer::FORM_C) === false) {
            $normalized = \Normalizer::normalize($text, \Normalizer::FORM_C);

            if (is_string($normalized)) {
                return $normalized;
            }
        }

        return $text;
    }
}
