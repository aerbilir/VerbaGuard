<?php

declare(strict_types=1);

use VerbaGuard\Language\TurkishProfile;
use VerbaGuard\VerbaGuard;

test('clean text returns false', function () {
    $guard = VerbaGuard::turkish();

    expect($guard->contains('Merhaba dunya'))->toBeFalse();
});

test('direct Turkish profanity returns true', function () {
    $guard = VerbaGuard::turkish();

    expect($guard->contains('siktir'))->toBeTrue();
});

test('uppercase and lowercase profanity are detected', function () {
    $guard = VerbaGuard::turkish();

    expect($guard->contains('AMK'))->toBeTrue();
    expect($guard->contains('amk'))->toBeTrue();
});

test('Turkish character folding is detected', function () {
    $guard = VerbaGuard::turkish();

    expect($guard->contains('merhaba'))->toBeFalse();
    expect($guard->contains('şiktir'))->toBeTrue();
    expect($guard->contains('SİKTİR'))->toBeTrue();
});

test('leetspeak variants are detected', function () {
    $guard = VerbaGuard::turkish();

    expect($guard->contains('4mk'))->toBeTrue();
    expect($guard->contains('@mk'))->toBeTrue();
});

test('repeated letters are detected', function () {
    $guard = VerbaGuard::turkish();

    expect($guard->contains('ammmmK'))->toBeTrue();
    expect($guard->contains('siiiktir'))->toBeTrue();
});

test('punctuation-separated profanity is detected', function () {
    $guard = VerbaGuard::turkish();

    expect($guard->contains('s.i.k.t.i.r'))->toBeTrue();
});

test('whitespace-separated profanity is detected', function () {
    $guard = VerbaGuard::turkish();

    expect($guard->contains('s i k t i r'))->toBeTrue();
});

test('analyze returns matches', function () {
    $guard = VerbaGuard::turkish();
    $result = $guard->analyze('amk');

    expect($result->hasProfanity())->toBeTrue();
    expect($result->matches())->not->toBeEmpty();
    expect($result->matches()[0]->term())->toBe('amk');
    expect($result->matches()[0]->language())->toBe('tr');
});

test('score increases with severity', function () {
    $guard = VerbaGuard::turkish();

    $lowScore = $guard->score('aq');
    $mediumScore = $guard->score('amk');
    $highScore = $guard->score('siktir');

    expect($lowScore)->toBeLessThan($mediumScore);
    expect($mediumScore)->toBeLessThan($highScore);
});

test('mask preserves non-profane text', function () {
    $guard = VerbaGuard::turkish();

    $masked = $guard->mask('Bu bir amk testi');

    expect($masked)->toBe('Bu bir *** testi');
});

test('multiple language profiles can be registered', function () {
    $guard = VerbaGuard::forLanguages([
        new TurkishProfile(),
        new TurkishProfile(),
    ]);

    expect($guard->contains('amk'))->toBeTrue();
    expect($guard->analyze('amk')->matches())->not->toBeEmpty();
});

test('severity reflects highest match', function () {
    $guard = VerbaGuard::turkish();

    expect($guard->analyze('aq')->severity())->toBe('low');
    expect($guard->analyze('amk')->severity())->toBe('medium');
    expect($guard->analyze('siktir')->severity())->toBe('high');
});

test('score helper matches analyze score', function () {
    $guard = VerbaGuard::turkish();
    $text = 'amk';

    expect($guard->score($text))->toBe($guard->analyze($text)->score());
});

test('mask helper matches analyze masked output', function () {
    $guard = VerbaGuard::turkish();
    $text = 'amk test';

    expect($guard->mask($text))->toBe($guard->analyze($text)->masked());
});
