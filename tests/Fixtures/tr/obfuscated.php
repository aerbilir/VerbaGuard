<?php

declare(strict_types=1);

/**
 * Turkish obfuscated corpus — evasion detection cases.
 *
 * Test-only offensive text. See README.md in this directory.
 */
return [
    [
        'id' => 'obfuscated.amk.leetspeak-4',
        'text' => '4mk',
        'expect' => [
            'detected' => true,
            'terms' => ['amk'],
        ],
        'tags' => ['leetspeak'],
    ],
    [
        'id' => 'obfuscated.amk.leetspeak-at',
        'text' => '@mk',
        'expect' => [
            'detected' => true,
            'terms' => ['amk'],
        ],
        'tags' => ['leetspeak'],
    ],
    [
        'id' => 'obfuscated.siktir.leetspeak',
        'text' => 's1kt1r',
        'expect' => [
            'detected' => true,
            'terms' => ['siktir'],
        ],
        'tags' => ['leetspeak'],
    ],
    [
        'id' => 'obfuscated.siktir.dots',
        'text' => 's.i.k.t.i.r',
        'expect' => [
            'detected' => true,
            'terms' => ['siktir'],
        ],
        'tags' => ['separator-chain'],
    ],
    [
        'id' => 'obfuscated.siktir.spaces',
        'text' => 's i k t i r',
        'expect' => [
            'detected' => true,
            'terms' => ['siktir'],
        ],
        'tags' => ['separator-chain'],
    ],
    [
        'id' => 'obfuscated.amk.spaced',
        'text' => 'a m k',
        'expect' => [
            'detected' => true,
            'terms' => ['amk'],
        ],
        'tags' => ['separator-chain'],
    ],
    [
        'id' => 'obfuscated.amk.partial-space',
        'text' => 'am k',
        'expect' => [
            'detected' => true,
            'terms' => ['amk'],
        ],
        'tags' => ['separator-chain'],
    ],
    [
        'id' => 'obfuscated.aq.dots',
        'text' => 'a.q',
        'expect' => [
            'detected' => true,
            'terms' => ['aq'],
        ],
        'tags' => ['separator-chain'],
    ],
    [
        'id' => 'obfuscated.siktir.turkish-fold',
        'text' => 'şiktir',
        'expect' => [
            'detected' => true,
            'terms' => ['siktir'],
        ],
        'tags' => ['turkish-chars'],
    ],
    [
        'id' => 'obfuscated.amk.repeated-letters',
        'text' => 'ammmmK',
        'expect' => [
            'detected' => true,
            'terms' => ['amk'],
        ],
        'tags' => ['repeated-letters'],
    ],
];
