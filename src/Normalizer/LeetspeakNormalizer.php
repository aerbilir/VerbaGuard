<?php

declare(strict_types=1);

namespace VerbaGuard\Normalizer;

final class LeetspeakNormalizer implements Normalizer
{
  /** @var array<string, string> */
    private const MAP = [
        '0' => 'o',
        '1' => 'i',
        '!' => 'i',
        '3' => 'e',
        '4' => 'a',
        '@' => 'a',
        '5' => 's',
        '$' => 's',
        '7' => 't',
    ];

    public function normalize(string $text): string
    {
        if ($text === '') {
            return $text;
        }

        return strtr($text, self::MAP);
    }
}
