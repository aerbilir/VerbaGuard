<?php

declare(strict_types=1);

namespace VerbaGuard\Dictionary;

final class Dictionary
{
    /** @var array<string, Entry> */
    private array $byNormalized = [];

    /**
     * @param list<Entry> $entries
     */
    public function __construct(array $entries)
    {
        foreach ($entries as $entry) {
            $this->byNormalized[$entry->normalized] = $entry;
        }
    }

    /**
     * @param list<array{term: string, category: string, severity: string}> $rows
     */
    public static function fromRows(array $rows, callable $normalizeKey): self
    {
        return (new DictionaryBuilder($normalizeKey))->build($rows);
    }

    public function find(string $normalized): ?Entry
    {
        return $this->byNormalized[$normalized] ?? null;
    }

    /**
     * @return list<Entry>
     */
    public function entries(): array
    {
        return array_values($this->byNormalized);
    }
}
