<?php

declare(strict_types=1);

namespace VerbaGuard\Normalizer;

final class TurkishNormalizer implements Normalizer
{
    public function normalize(string $text): string
    {
        if ($text === '') {
            return $text;
        }

        $text = str_replace('İ', 'i', $text);
        $text = mb_strtolower($text, 'UTF-8');

        return strtr($text, [
            'ç' => 'c',
            'ğ' => 'g',
            'ı' => 'i',
            'ö' => 'o',
            'ş' => 's',
            'ü' => 'u',
        ]);
    }
}
