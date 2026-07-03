<?php

declare(strict_types=1);

use VerbaGuard\Tests\Support\CorpusLoader;
use VerbaGuard\Tests\Support\CorpusQualityReport;
use VerbaGuard\VerbaGuard;

function turkishGuard(): VerbaGuard
{
    return VerbaGuard::turkish();
}

/**
 * @param array<string, mixed> $case
 */
function assertCorpusExpectations(VerbaGuard $guard, array $case): void
{
    /** @var array{detected: bool, terms?: list<string>, match_count?: int, severity?: string, categories?: list<string>} $expect */
    $expect = $case['expect'];
    $result = $guard->analyze($case['text']);

    expect($result->hasProfanity())->toBe($expect['detected']);

    if (! $expect['detected']) {
        return;
    }

    if (isset($expect['match_count'])) {
        expect($result->matches())->toHaveCount($expect['match_count']);
    }

    if (isset($expect['terms'])) {
        $matchedTerms = array_map(
            static fn ($match): string => $match->term(),
            $result->matches(),
        );

        foreach ($expect['terms'] as $term) {
            expect($matchedTerms)->toContain($term);
        }
    }

    if (isset($expect['severity'])) {
        expect($result->severity())->toBe($expect['severity']);
    }

    if (isset($expect['categories'])) {
        $matchedCategories = array_map(
            static fn ($match): string => $match->category(),
            $result->matches(),
        );

        foreach ($expect['categories'] as $category) {
            expect($matchedCategories)->toContain($category);
        }
    }
}

test('clean corpus produces no false positives', function (array $case) {
    assertCorpusExpectations(turkishGuard(), $case);
})->with(fn (): array => array_map(
    static fn (array $case): array => [$case],
    CorpusLoader::loadClean(),
));

test('profane corpus is detected', function (array $case) {
    assertCorpusExpectations(turkishGuard(), $case);
})->with(fn (): array => array_map(
    static fn (array $case): array => [$case],
    CorpusLoader::loadProfane(),
));

test('obfuscated corpus is detected', function (array $case) {
    assertCorpusExpectations(turkishGuard(), $case);
})->with(fn (): array => array_map(
    static fn (array $case): array => [$case],
    CorpusLoader::loadObfuscated(),
));

test('edge cases match expectations', function (array $case) {
    assertCorpusExpectations(turkishGuard(), $case);
})->with(fn (): array => array_map(
    static fn (array $case): array => [$case],
    CorpusLoader::loadEdge(),
));

test('aggregate report has zero false positives', function () {
    $report = CorpusQualityReport::fromAllFixtures(turkishGuard());

    expect($report->falsePositiveCount())->toBe(0)
        ->and($report->falsePositiveCases())->toBe([]);
});

test('aggregate report has zero false negatives', function () {
    $report = CorpusQualityReport::fromAllFixtures(turkishGuard());

    expect($report->falseNegativeCount())->toBe(0)
        ->and($report->falseNegativeCases())->toBe([]);
});

test('aggregate detection coverage is 100', function () {
    $report = CorpusQualityReport::fromDetectionCorpus(turkishGuard());

    expect($report->detectionCoverage())->toBe(100.0);
});
