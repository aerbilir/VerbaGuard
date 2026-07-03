<?php

declare(strict_types=1);

use VerbaGuard\Dictionary\Dictionary;
use VerbaGuard\Dictionary\Entry;

function dictionaryRow(
    string $term = 'amk',
    string $category = 'profanity',
    string $severity = 'medium',
): array {
    return [
        'term' => $term,
        'category' => $category,
        'severity' => $severity,
    ];
}

test('fromRows minimal format produces Entry', function () {
    $dictionary = Dictionary::fromRows(
        [dictionaryRow()],
        static fn (string $term): string => $term,
    );

    $entry = $dictionary->entries()[0];

    expect($entry)->toBeInstanceOf(Entry::class)
        ->and($entry->term)->toBe('amk')
        ->and($entry->category)->toBe('profanity')
        ->and($entry->severity)->toBe('medium');
});

test('fromRows derives normalized at build time', function () {
    $dictionary = Dictionary::fromRows(
        [dictionaryRow(term: 'AMK')],
        static fn (string $term): string => mb_strtolower($term, 'UTF-8'),
    );

    expect($dictionary->entries()[0]->normalized)->toBe('amk');
});

test('fromRows uses normalizeKey callable', function () {
    $dictionary = Dictionary::fromRows(
        [dictionaryRow(term: 'test')],
        static fn (string $term): string => 'normalized:' . $term,
    );

    expect($dictionary->entries()[0]->normalized)->toBe('normalized:test')
        ->and($dictionary->find('normalized:test'))->not->toBeNull()
        ->and($dictionary->find('test'))->toBeNull();
});

test('fromRows rejects invalid severity', function () {
    Dictionary::fromRows(
        [dictionaryRow(severity: 'extreme')],
        static fn (string $term): string => $term,
    );
})->throws(InvalidArgumentException::class);

test('fromRows rejects empty term', function () {
    Dictionary::fromRows(
        [dictionaryRow(term: '')],
        static fn (string $term): string => $term,
    );
})->throws(InvalidArgumentException::class);

test('fromRows rejects empty category', function () {
    Dictionary::fromRows(
        [dictionaryRow(category: '')],
        static fn (string $term): string => $term,
    );
})->throws(InvalidArgumentException::class);

test('fromRows rejects normalized in author input', function () {
    Dictionary::fromRows(
        [
            [
                'term' => 'amk',
                'normalized' => 'amk',
                'category' => 'profanity',
                'severity' => 'medium',
            ],
        ],
        static fn (string $term): string => $term,
    );
})->throws(InvalidArgumentException::class, 'Author dictionary rows must not include "normalized"');

test('fromRows rejects unknown author field', function () {
    Dictionary::fromRows(
        [
            [
                'term' => 'amk',
                'category' => 'profanity',
                'severity' => 'medium',
                'alias' => 'amq',
            ],
        ],
        static fn (string $term): string => $term,
    );
})->throws(InvalidArgumentException::class, 'Unknown author field');

test('fromRows rejects missing required field', function () {
    Dictionary::fromRows(
        [
            [
                'term' => 'amk',
                'category' => 'profanity',
            ],
        ],
        static fn (string $term): string => $term,
    );
})->throws(InvalidArgumentException::class, 'Missing required author field');

test('fromRows rejects duplicate normalized key', function () {
    Dictionary::fromRows(
        [
            dictionaryRow(term: 'foo'),
            dictionaryRow(term: 'FOO'),
        ],
        static fn (string $term): string => mb_strtolower($term, 'UTF-8'),
    );
})->throws(InvalidArgumentException::class, 'Duplicate normalized key');

test('find works with derived normalized key', function () {
    $dictionary = Dictionary::fromRows(
        [dictionaryRow(term: 'AMK')],
        static fn (string $term): string => mb_strtolower($term, 'UTF-8'),
    );

    $entry = $dictionary->find('amk');

    expect($entry)->not->toBeNull()
        ->and($entry->term)->toBe('AMK')
        ->and($entry->normalized)->toBe('amk');
});

test('entries returns author and derived fields', function () {
    $dictionary = Dictionary::fromRows(
        [dictionaryRow(term: 'siktir', category: 'profanity', severity: 'high')],
        static fn (string $term): string => mb_strtolower($term, 'UTF-8'),
    );

    $entry = $dictionary->entries()[0];

    expect($entry->term)->toBe('siktir')
        ->and($entry->category)->toBe('profanity')
        ->and($entry->severity)->toBe('high')
        ->and($entry->normalized)->toBe('siktir');
});
