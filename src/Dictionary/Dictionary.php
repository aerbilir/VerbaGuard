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
     * @param list<array{term: string, normalized: string, category: string, severity: string}> $rows
     */
    public static function fromArray(array $rows): self
    {
        $entries = array_map(
            static fn (array $row): Entry => Entry::fromArray($row),
            $rows,
        );

        return new self($entries);
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
