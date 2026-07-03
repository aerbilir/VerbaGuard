<?php

declare(strict_types=1);

namespace VerbaGuard\Dictionary;

use InvalidArgumentException;
use VerbaGuard\Severity;
use ValueError;

final class DictionaryBuilder
{
    /** @var list<string> */
    private const AUTHOR_FIELDS = ['term', 'category', 'severity'];

    /** @var callable(string): string */
    private $normalizeKey;

    /**
     * @param callable(string): string $normalizeKey
     */
    public function __construct(callable $normalizeKey)
    {
        $this->normalizeKey = $normalizeKey;
    }

    /**
     * @param list<array<string, string>> $rows
     */
    public function build(array $rows): Dictionary
    {
        /** @var array<string, Entry> $byNormalized */
        $byNormalized = [];

        foreach ($rows as $index => $row) {
            $this->assertAuthorRowShape($row, $index);

            $term = $row['term'];
            $category = $row['category'];
            $severity = $row['severity'];

            $this->assertNonEmptyString($term, 'term', $index);
            $this->assertNonEmptyString($category, 'category', $index);
            $this->assertValidSeverity($severity, $index);

            $normalized = ($this->normalizeKey)($term);

            if (isset($byNormalized[$normalized])) {
                throw new InvalidArgumentException(
                    sprintf('Duplicate normalized key "%s" at row %d.', $normalized, $index),
                );
            }

            $byNormalized[$normalized] = Entry::fromRow(
                [
                    'term' => $term,
                    'category' => $category,
                    'severity' => $severity,
                ],
                $normalized,
            );
        }

        return new Dictionary(array_values($byNormalized));
    }

    /**
     * @param array<string, string> $row
     */
    private function assertAuthorRowShape(array $row, int $index): void
    {
        if (array_key_exists('normalized', $row)) {
            throw new InvalidArgumentException(
                sprintf('Author dictionary rows must not include "normalized" (row %d).', $index),
            );
        }

        foreach (array_keys($row) as $field) {
            if (! in_array($field, self::AUTHOR_FIELDS, true)) {
                throw new InvalidArgumentException(
                    sprintf('Unknown author field "%s" at row %d.', $field, $index),
                );
            }
        }

        foreach (self::AUTHOR_FIELDS as $field) {
            if (! array_key_exists($field, $row)) {
                throw new InvalidArgumentException(
                    sprintf('Missing required author field "%s" at row %d.', $field, $index),
                );
            }
        }
    }

    private function assertNonEmptyString(string $value, string $field, int $index): void
    {
        if ($value === '') {
            throw new InvalidArgumentException(
                sprintf('Author field "%s" must not be empty at row %d.', $field, $index),
            );
        }
    }

    private function assertValidSeverity(string $severity, int $index): void
    {
        try {
            Severity::fromString($severity);
        } catch (ValueError $exception) {
            throw new InvalidArgumentException(
                sprintf('Invalid severity "%s" at row %d.', $severity, $index),
                0,
                $exception,
            );
        }
    }
}
