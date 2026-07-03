<?php

declare(strict_types=1);

namespace VerbaGuard\Tests\Support;

use InvalidArgumentException;

final class CorpusLoader
{
    /** @var list<string>|null */
    private static ?array $seedTerms = null;

    /** @var list<string> */
    private const CASE_FIELDS = ['id', 'text', 'expect', 'tags', 'note', 'risk'];

    /** @var list<string> */
    private const EXPECT_FIELDS = ['detected', 'terms', 'match_count', 'severity', 'categories'];

    /** @var list<string> */
    private const FIXTURE_FILES = [
        'clean',
        'profane',
        'obfuscated',
        'edge_cases',
    ];

    /**
     * @return list<array<string, mixed>>
     */
    public static function load(string $name): array
    {
        $path = self::fixturePath($name);
        /** @var list<array<string, mixed>> $rows */
        $rows = require $path;

        return self::validateCases($rows, $name);
    }

    /**
     * @return list<array<string, mixed>>
     */
    public static function all(): array
    {
        $cases = [];
        $seenIds = [];

        foreach (self::FIXTURE_FILES as $name) {
            foreach (self::load($name) as $case) {
                $id = $case['id'];

                if (isset($seenIds[$id])) {
                    throw new InvalidArgumentException(
                        sprintf('Duplicate corpus id "%s" across fixtures.', $id),
                    );
                }

                $seenIds[$id] = true;
                $cases[] = $case;
            }
        }

        return $cases;
    }

    /**
     * @return list<array<string, mixed>>
     */
    public static function loadClean(): array
    {
        return self::load('clean');
    }

    /**
     * @return list<array<string, mixed>>
     */
    public static function loadProfane(): array
    {
        return self::load('profane');
    }

    /**
     * @return list<array<string, mixed>>
     */
    public static function loadObfuscated(): array
    {
        return self::load('obfuscated');
    }

    /**
     * @return list<array<string, mixed>>
     */
    public static function loadEdge(): array
    {
        return self::load('edge_cases');
    }

    private static function fixturePath(string $name): string
    {
        return dirname(__DIR__) . '/Fixtures/tr/' . $name . '.php';
    }

    /**
     * @param list<array<string, mixed>> $rows
     *
     * @return list<array<string, mixed>>
     */
    private static function validateCases(array $rows, string $fixtureName): array
    {
        $seenIds = [];
        $allowEmptyText = $fixtureName === 'edge_cases';

        foreach ($rows as $index => $case) {
            if (! is_array($case)) {
                throw new InvalidArgumentException(
                    sprintf('Corpus case at index %d in %s must be an array.', $index, $fixtureName),
                );
            }

            self::assertKnownCaseFields($case, $fixtureName, $index);
            self::assertRequiredFields($case, $fixtureName, $index);
            self::assertTextRule($case, $fixtureName, $index, $allowEmptyText);
            self::assertExpectShape($case, $fixtureName, $index);

            $id = $case['id'];

            if (! is_string($id) || $id === '') {
                throw new InvalidArgumentException(
                    sprintf('Corpus case id must be a non-empty string at index %d in %s.', $index, $fixtureName),
                );
            }

            if (isset($seenIds[$id])) {
                throw new InvalidArgumentException(
                    sprintf('Duplicate corpus id "%s" in %s.', $id, $fixtureName),
                );
            }

            $seenIds[$id] = true;
        }

        return $rows;
    }

    /**
     * @param array<string, mixed> $case
     */
    private static function assertKnownCaseFields(array $case, string $fixtureName, int $index): void
    {
        foreach (array_keys($case) as $field) {
            if (! in_array($field, self::CASE_FIELDS, true)) {
                throw new InvalidArgumentException(
                    sprintf('Unknown corpus field "%s" at index %d in %s.', $field, $index, $fixtureName),
                );
            }
        }
    }

    /**
     * @param array<string, mixed> $case
     */
    private static function assertRequiredFields(array $case, string $fixtureName, int $index): void
    {
        foreach (['id', 'text', 'expect'] as $field) {
            if (! array_key_exists($field, $case)) {
                throw new InvalidArgumentException(
                    sprintf('Missing required corpus field "%s" at index %d in %s.', $field, $index, $fixtureName),
                );
            }
        }
    }

    /**
     * @param array<string, mixed> $case
     */
    private static function assertTextRule(array $case, string $fixtureName, int $index, bool $allowEmptyText): void
    {
        if (! is_string($case['text'])) {
            throw new InvalidArgumentException(
                sprintf('Corpus field "text" must be a string at index %d in %s.', $index, $fixtureName),
            );
        }

        if ($case['text'] === '' && ! $allowEmptyText) {
            throw new InvalidArgumentException(
                sprintf('Corpus field "text" must not be empty at index %d in %s.', $index, $fixtureName),
            );
        }
    }

    /**
     * @param array<string, mixed> $case
     */
    private static function assertExpectShape(array $case, string $fixtureName, int $index): void
    {
        if (! is_array($case['expect'])) {
            throw new InvalidArgumentException(
                sprintf('Corpus field "expect" must be an array at index %d in %s.', $index, $fixtureName),
            );
        }

        foreach (array_keys($case['expect']) as $field) {
            if (! in_array($field, self::EXPECT_FIELDS, true)) {
                throw new InvalidArgumentException(
                    sprintf('Unknown expect field "%s" at index %d in %s.', $field, $index, $fixtureName),
                );
            }
        }

        if (! array_key_exists('detected', $case['expect'])) {
            throw new InvalidArgumentException(
                sprintf('Missing expect.detected at index %d in %s.', $index, $fixtureName),
            );
        }

        if (! is_bool($case['expect']['detected'])) {
            throw new InvalidArgumentException(
                sprintf('expect.detected must be a boolean at index %d in %s.', $index, $fixtureName),
            );
        }

        if (array_key_exists('terms', $case['expect'])) {
            if (! is_array($case['expect']['terms'])) {
                throw new InvalidArgumentException(
                    sprintf('expect.terms must be an array at index %d in %s.', $index, $fixtureName),
                );
            }

            foreach ($case['expect']['terms'] as $term) {
                if (! is_string($term) || ! in_array($term, self::seedTerms(), true)) {
                    throw new InvalidArgumentException(
                        sprintf('Invalid expect.terms entry at index %d in %s.', $index, $fixtureName),
                    );
                }
            }
        }
    }

    /**
     * @return list<string>
     */
    private static function seedTerms(): array
    {
        if (self::$seedTerms !== null) {
            return self::$seedTerms;
        }

        /** @var list<array{term: string, category: string, severity: string}> $rows */
        $rows = require dirname(__DIR__, 2) . '/data/tr.php';
        $terms = [];

        foreach ($rows as $index => $row) {
            if (! is_array($row) || ! array_key_exists('term', $row) || ! is_string($row['term']) || $row['term'] === '') {
                throw new InvalidArgumentException(
                    sprintf('Invalid seed dictionary row at index %d in data/tr.php.', $index),
                );
            }

            $terms[] = $row['term'];
        }

        self::$seedTerms = $terms;

        return self::$seedTerms;
    }
}
