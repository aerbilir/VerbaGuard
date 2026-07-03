<?php

declare(strict_types=1);

/**
 * Turkish profane corpus — direct detection cases.
 *
 * Test-only offensive text. See README.md in this directory.
 */
return [
    [
        'id' => 'profane.amk.direct',
        'text' => 'amk',
        'expect' => [
            'detected' => true,
            'terms' => ['amk'],
        ],
        'tags' => ['direct'],
    ],
    [
        'id' => 'profane.aq.direct',
        'text' => 'aq',
        'expect' => [
            'detected' => true,
            'terms' => ['aq'],
        ],
        'tags' => ['direct'],
    ],
    [
        'id' => 'profane.siktir.direct',
        'text' => 'siktir',
        'expect' => [
            'detected' => true,
            'terms' => ['siktir'],
        ],
        'tags' => ['direct'],
    ],
    [
        'id' => 'profane.orospu.direct',
        'text' => 'orospu',
        'expect' => [
            'detected' => true,
            'terms' => ['orospu'],
        ],
        'tags' => ['direct'],
    ],
    [
        'id' => 'profane.mal.standalone',
        'text' => 'mal',
        'expect' => [
            'detected' => true,
            'terms' => ['mal'],
        ],
        'tags' => ['direct', 'short-term'],
    ],
    [
        'id' => 'profane.mal.in-sentence',
        'text' => 'bu mal bir şey',
        'expect' => [
            'detected' => true,
            'terms' => ['mal'],
        ],
        'tags' => ['sentence', 'short-term'],
    ],
    [
        'id' => 'profane.amk.uppercase',
        'text' => 'AMK',
        'expect' => [
            'detected' => true,
            'terms' => ['amk'],
        ],
        'tags' => ['case-variant'],
    ],
    [
        'id' => 'profane.siktir.sentence',
        'text' => 'git siktir',
        'expect' => [
            'detected' => true,
            'terms' => ['siktir'],
        ],
        'tags' => ['sentence'],
    ],
    [
        'id' => 'profane.multi.amk-aq',
        'text' => 'amk ve aq',
        'expect' => [
            'detected' => true,
            'terms' => ['amk', 'aq'],
            'match_count' => 2,
        ],
        'tags' => ['multi-match'],
    ],
    [
        'id' => 'profane.siktir.turkish-case',
        'text' => 'SİKTİR',
        'expect' => [
            'detected' => true,
            'terms' => ['siktir'],
        ],
        'tags' => ['case-variant', 'turkish-chars'],
    ],
];
