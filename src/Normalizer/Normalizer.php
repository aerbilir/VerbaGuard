<?php

declare(strict_types=1);

namespace VerbaGuard\Normalizer;

interface Normalizer
{
    public function normalize(string $text): string;
}
