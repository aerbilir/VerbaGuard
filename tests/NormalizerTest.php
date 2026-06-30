<?php

declare(strict_types=1);

use VerbaGuard\Normalizer\CompactNormalizer;
use VerbaGuard\Normalizer\LeetspeakNormalizer;
use VerbaGuard\Normalizer\RepeatedLetterNormalizer;
use VerbaGuard\Normalizer\TurkishNormalizer;
use VerbaGuard\Normalizer\UnicodeNormalizer;

test('unicode normalizer leaves ascii unchanged', function () {
    $normalizer = new UnicodeNormalizer();

    expect($normalizer->normalize('hello'))->toBe('hello');
});

test('turkish normalizer folds characters', function () {
    $normalizer = new TurkishNormalizer();

    expect($normalizer->normalize('ÇĞIİÖŞÜ'))->toBe('cgiiosu');
});

test('leetspeak normalizer maps digits and symbols', function () {
    $normalizer = new LeetspeakNormalizer();

    expect($normalizer->normalize('4m1'))->toBe('ami');
});

test('repeated letter normalizer collapses three or more repeats', function () {
    $normalizer = new RepeatedLetterNormalizer();

    expect($normalizer->normalize('heeeello'))->toBe('hello');
    expect($normalizer->normalize('hellllo'))->toBe('helo');
    expect($normalizer->normalize('aa'))->toBe('aa');
});

test('compact normalizer removes separators', function () {
    $normalizer = new CompactNormalizer();

    expect($normalizer->normalize('s.i.k.t.i.r'))->toBe('siktir');
    expect($normalizer->normalize('s i k t i r'))->toBe('siktir');
});
