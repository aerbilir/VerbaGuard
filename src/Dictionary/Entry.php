<?php

declare(strict_types=1);

namespace VerbaGuard\Dictionary;

final class Entry
{
    public function __construct(
        public readonly string $term,
        public readonly string $normalized,
        public readonly string $category,
        public readonly string $severity,
    ) {
    }

    /**
     * @param array{term: string, normalized: string, category: string, severity: string} $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['term'],
            $data['normalized'],
            $data['category'],
            $data['severity'],
        );
    }
}
