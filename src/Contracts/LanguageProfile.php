<?php

declare(strict_types=1);

namespace VerbaGuard\Contracts;

use VerbaGuard\Dictionary\Dictionary;
use VerbaGuard\Normalizer\Normalizer;

interface LanguageProfile
{
    public function code(): string;

    public function dictionary(): Dictionary;

    /**
     * @return list<Normalizer>
     */
    public function normalizers(): array;
}
