<?php

declare(strict_types=1);

/**
 * Turkish edge-case corpus — boundary behavior.
 *
 * Test-only text. See README.md in this directory.
 */
return [
    [
        'id' => 'edge.spelled-chain.normal.spaces',
        'text' => 'n o r m a l',
        'expect' => ['detected' => false],
        'tags' => ['separator-chain', 'false-positive-risk'],
        'note' => 'Full chain normalizes to normal, not mal',
    ],
    [
        'id' => 'edge.spelled-chain.normal.dots',
        'text' => 'n.o.r.m.a.l',
        'expect' => ['detected' => false],
        'tags' => ['separator-chain', 'false-positive-risk'],
    ],
    [
        'id' => 'edge.spelled-chain.aq-neighbor',
        'text' => 'x a q y',
        'expect' => ['detected' => false],
        'tags' => ['separator-chain', 'aq-risk'],
    ],
    [
        'id' => 'edge.spelled-chain.mal.spaces',
        'text' => 'm a l',
        'expect' => [
            'detected' => true,
            'terms' => ['mal'],
        ],
        'tags' => ['separator-chain', 'short-term'],
    ],
    [
        'id' => 'edge.empty.string',
        'text' => '',
        'expect' => ['detected' => false],
        'tags' => ['empty-input'],
    ],
    [
        'id' => 'edge.whitespace.only',
        'text' => '   ',
        'expect' => ['detected' => false],
        'tags' => ['empty-input'],
    ],
    [
        'id' => 'edge.malzeme.boundary',
        'text' => 'malzeme',
        'expect' => ['detected' => false],
        'tags' => ['substring', 'mal-risk'],
        'note' => 'Boundary check: mal inside malzeme must not match',
    ],
    [
        'id' => 'edge.mal.standalone-in-sentence',
        'text' => 'bu mal bir şey',
        'expect' => [
            'detected' => true,
            'terms' => ['mal'],
        ],
        'tags' => ['sentence', 'short-term'],
    ],
    [
        'id' => 'edge.siktir.repeated-letters',
        'text' => 'siiiktir',
        'expect' => [
            'detected' => true,
            'terms' => ['siktir'],
        ],
        'tags' => ['repeated-letters'],
    ],
    [
        'id' => 'edge.siktir.turkish-variant',
        'text' => 'sıktır',
        'expect' => [
            'detected' => true,
            'terms' => ['siktir'],
        ],
        'tags' => ['turkish-chars'],
    ],
];
