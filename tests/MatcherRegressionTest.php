<?php

declare(strict_types=1);

use VerbaGuard\VerbaGuard;

test('false positives are not flagged for embedded short terms', function (string $text) {
    $guard = VerbaGuard::turkish();

    expect($guard->contains($text))->toBeFalse();
})->with([
    'normal',
    'animal',
    'formal',
    'small',
    'malzeme',
    'küçük malzeme',
    'kamk',
    'şamk',
]);

test('true positives are detected for profanity variants', function (string $text) {
    $guard = VerbaGuard::turkish();

    expect($guard->contains($text))->toBeTrue();
})->with([
    'amk',
    'bu mal bir şey',
    's.i.k.t.i.r',
    's i k t i r',
    'a.q',
    'am k',
    'sıktır',
    's1kt1r',
]);

test('masking preserves UTF-8 text around matches', function () {
    $guard = VerbaGuard::turkish();

    expect($guard->mask('Bu bir amk testi'))->toBe('Bu bir *** testi');
    expect($guard->mask('şi amk'))->toBe('şi ***');
});

test('masking handles separator obfuscation spans', function () {
    $guard = VerbaGuard::turkish();

    expect($guard->mask('s.i.k.t.i.r'))->toBe('***********');
    expect($guard->mask('s i k t i r'))->toBe('***********');
});

test('masking handles multiple matches', function () {
    $guard = VerbaGuard::turkish();

    expect($guard->mask('amk ve aq'))->toBe('*** ve **');
});

test('separator matches report accurate byte spans', function () {
    $guard = VerbaGuard::turkish();
    $result = $guard->analyze('s.i.k.t.i.r');

    expect($result->matches())->toHaveCount(1);
    expect($result->matches()[0]->term())->toBe('siktir');
    expect($result->matches()[0]->start())->toBe(0);
    expect($result->matches()[0]->length())->toBe(11);
    expect($result->matches()[0]->original())->toBe('s.i.k.t.i.r');
});

test('standalone insult token is detected without substring false positive', function () {
    $guard = VerbaGuard::turkish();

    expect($guard->contains('bu mal bir şey'))->toBeTrue();
    expect($guard->contains('malzeme'))->toBeFalse();
});

test('spelled chain false positives are rejected', function (string $text) {
    $guard = VerbaGuard::turkish();

    expect($guard->contains($text))->toBeFalse();
})->with([
    'n o r m a l',
    'n.o.r.m.a.l',
    'x a q y',
]);

test('spelled chain full-chain matches are accepted', function (string $text) {
    $guard = VerbaGuard::turkish();

    expect($guard->contains($text))->toBeTrue();
})->with([
    'a m k',
    'am k',
    'a.q',
    's i k t i r',
    's.i.k.t.i.r',
    'm a l',
]);

test('spelled chain distinguishes full word from spelled insult', function () {
    $guard = VerbaGuard::turkish();

    expect($guard->contains('n o r m a l'))->toBeFalse();
    expect($guard->contains('m a l'))->toBeTrue();
});
