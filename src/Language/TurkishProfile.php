<?php

declare(strict_types=1);

namespace VerbaGuard\Language;

use VerbaGuard\Contracts\LanguageProfile;
use VerbaGuard\Dictionary\Dictionary;
use VerbaGuard\Normalizer\Normalizer;
use VerbaGuard\Normalizer\TurkishNormalizer;

final class TurkishProfile implements LanguageProfile
{
    private ?Dictionary $dictionary = null;

    public function code(): string
    {
        return 'tr';
    }

    public function dictionary(): Dictionary
    {
        if ($this->dictionary === null) {
            /** @var list<array{term: string, normalized: string, category: string, severity: string}> $rows */
            $rows = require dirname(__DIR__, 2) . '/data/tr.php';
            $this->dictionary = Dictionary::fromArray($rows);
        }

        return $this->dictionary;
    }

    public function normalizers(): array
    {
        return [new TurkishNormalizer()];
    }
}
