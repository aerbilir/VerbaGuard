<?php

declare(strict_types=1);

namespace VerbaGuard\Dictionary;

final class Entry
{
    /**
     * @param string $term Author field — canonical dictionary term.
     * @param string $normalized Derived field — build-time normalized lookup key.
     * @param string $category Author field — semantic category.
     * @param string $severity Author field — one of clean, low, medium, high.
     */
    public function __construct(
        public readonly string $term,
        public readonly string $normalized,
        public readonly string $category,
        public readonly string $severity,
    ) {
    }

    /**
     * @param array{term: string, category: string, severity: string} $row
     */
    public static function fromRow(array $row, string $normalized): self
    {
        return new self(
            $row['term'],
            $normalized,
            $row['category'],
            $row['severity'],
        );
    }
}
