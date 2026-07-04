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
    [
        'id' => 'obfuscated.gerizekali.leetspeak',
        'text' => 'g3r1z3kal1',
        'expect' => [
            'detected' => true,
            'terms' => ['gerizekalı'],
        ],
        'tags' => ['leetspeak'],
    ],
    [
        'id' => 'obfuscated.gerizekali.spaces',
        'text' => 'g e r i z e k a l i',
        'expect' => [
            'detected' => true,
            'terms' => ['gerizekalı'],
        ],
        'tags' => ['separator-chain'],
    ],
    [
        'id' => 'obfuscated.gerizekali.turkish-case',
        'text' => 'GERİZEKALI',
        'expect' => [
            'detected' => true,
            'terms' => ['gerizekalı'],
        ],
        'tags' => ['case-variant', 'turkish-chars'],
        'note' => 'gerzek chat truncation remains undetected without a separate row',
    ],
    [
        'id' => 'obfuscated.dangalak.leetspeak',
        'text' => 'd4ng4lak',
        'expect' => [
            'detected' => true,
            'terms' => ['dangalak'],
        ],
        'tags' => ['leetspeak'],
    ],
    [
        'id' => 'obfuscated.dangalak.repeated-letters',
        'text' => 'dangalakkk',
        'expect' => [
            'detected' => true,
            'terms' => ['dangalak'],
        ],
        'tags' => ['repeated-letters'],
    ],
    [
        'id' => 'obfuscated.dangalak.spaces',
        'text' => 'd a n g a l a k',
        'expect' => [
            'detected' => true,
            'terms' => ['dangalak'],
        ],
        'tags' => ['separator-chain'],
    ],
    [
        'id' => 'obfuscated.pezevenk.leetspeak',
        'text' => 'p3zevenk',
        'expect' => [
            'detected' => true,
            'terms' => ['pezevenk'],
        ],
        'tags' => ['leetspeak'],
    ],
    [
        'id' => 'obfuscated.pezevenk.dots',
        'text' => 'p.e.z.e.v.e.n.k',
        'expect' => [
            'detected' => true,
            'terms' => ['pezevenk'],
        ],
        'tags' => ['separator-chain'],
        'note' => 'pzvnk chat truncation remains undetected without a separate row',
    ],
    [
        'id' => 'obfuscated.pezevenk.repeated-letters',
        'text' => 'pezevenkkk',
        'expect' => [
            'detected' => true,
            'terms' => ['pezevenk'],
        ],
        'tags' => ['repeated-letters'],
    ],
    [
        'id' => 'obfuscated.salak.leetspeak',
        'text' => 's4lak',
        'expect' => [
            'detected' => true,
            'terms' => ['salak'],
        ],
        'tags' => ['leetspeak'],
    ],
    [
        'id' => 'obfuscated.salak.repeated-letters',
        'text' => 'salakkk',
        'expect' => [
            'detected' => true,
            'terms' => ['salak'],
        ],
        'tags' => ['repeated-letters'],
    ],
    [
        'id' => 'obfuscated.salak.spaces',
        'text' => 's a l a k',
        'expect' => [
            'detected' => true,
            'terms' => ['salak'],
        ],
        'tags' => ['separator-chain'],
    ],
    [
        'id' => 'obfuscated.kahpe.leetspeak',
        'text' => 'k4hpe',
        'expect' => [
            'detected' => true,
            'terms' => ['kahpe'],
        ],
        'tags' => ['leetspeak'],
    ],
    [
        'id' => 'obfuscated.kahpe.repeated-letters',
        'text' => 'kahpeee',
        'expect' => [
            'detected' => true,
            'terms' => ['kahpe'],
        ],
        'tags' => ['repeated-letters'],
    ],
    [
        'id' => 'obfuscated.kahpe.spaces',
        'text' => 'k a h p e',
        'expect' => [
            'detected' => true,
            'terms' => ['kahpe'],
        ],
        'tags' => ['separator-chain'],
    ],
    [
        'id' => 'obfuscated.kaltak.leetspeak',
        'text' => 'k4ltak',
        'expect' => [
            'detected' => true,
            'terms' => ['kaltak'],
        ],
        'tags' => ['leetspeak'],
    ],
    [
        'id' => 'obfuscated.kaltak.repeated-letters',
        'text' => 'kaltakkk',
        'expect' => [
            'detected' => true,
            'terms' => ['kaltak'],
        ],
        'tags' => ['repeated-letters'],
    ],
    [
        'id' => 'obfuscated.kaltak.spaces',
        'text' => 'k a l t a k',
        'expect' => [
            'detected' => true,
            'terms' => ['kaltak'],
        ],
        'tags' => ['separator-chain'],
    ],
    [
        'id' => 'obfuscated.surtuk.ascii-fold',
        'text' => 'surtuk',
        'expect' => [
            'detected' => true,
            'terms' => ['sürtük'],
        ],
        'tags' => ['turkish-chars'],
    ],
    [
        'id' => 'obfuscated.surtuk.repeated-letters',
        'text' => 'surtukkk',
        'expect' => [
            'detected' => true,
            'terms' => ['sürtük'],
        ],
        'tags' => ['repeated-letters', 'turkish-chars'],
    ],
    [
        'id' => 'obfuscated.surtuk.spaces',
        'text' => 's u r t u k',
        'expect' => [
            'detected' => true,
            'terms' => ['sürtük'],
        ],
        'tags' => ['separator-chain', 'turkish-chars'],
    ],
    [
        'id' => 'obfuscated.serefsiz.ascii-fold',
        'text' => 'serefsiz',
        'expect' => [
            'detected' => true,
            'terms' => ['şerefsiz'],
        ],
        'tags' => ['turkish-chars'],
    ],
    [
        'id' => 'obfuscated.serefsiz.leetspeak',
        'text' => 's3r3fs1z',
        'expect' => [
            'detected' => true,
            'terms' => ['şerefsiz'],
        ],
        'tags' => ['leetspeak', 'turkish-chars'],
    ],
    [
        'id' => 'obfuscated.serefsiz.spaces',
        'text' => 's e r e f s i z',
        'expect' => [
            'detected' => true,
            'terms' => ['şerefsiz'],
        ],
        'tags' => ['separator-chain', 'turkish-chars'],
    ],
    [
        'id' => 'obfuscated.gavat.leetspeak',
        'text' => 'g4v4t',
        'expect' => [
            'detected' => true,
            'terms' => ['gavat'],
        ],
        'tags' => ['leetspeak'],
    ],
    [
        'id' => 'obfuscated.gavat.repeated-letters',
        'text' => 'gavattt',
        'expect' => [
            'detected' => true,
            'terms' => ['gavat'],
        ],
        'tags' => ['repeated-letters'],
    ],
    [
        'id' => 'obfuscated.gavat.spaces',
        'text' => 'g a v a t',
        'expect' => [
            'detected' => true,
            'terms' => ['gavat'],
        ],
        'tags' => ['separator-chain'],
    ],
    [
        'id' => 'obfuscated.dalyarak.repeated-letters',
        'text' => 'dalyarakkk',
        'expect' => [
            'detected' => true,
            'terms' => ['dalyarak'],
        ],
        'tags' => ['repeated-letters'],
    ],
    [
        'id' => 'obfuscated.dalyarak.leetspeak',
        'text' => 'd4ly4r4k',
        'expect' => [
            'detected' => true,
            'terms' => ['dalyarak'],
        ],
        'tags' => ['leetspeak'],
    ],
    [
        'id' => 'obfuscated.dalyarak.spaces',
        'text' => 'd a l y a r a k',
        'expect' => [
            'detected' => true,
            'terms' => ['dalyarak'],
        ],
        'tags' => ['separator-chain'],
    ],
    [
        'id' => 'obfuscated.andaval.leetspeak',
        'text' => '4ndaval',
        'expect' => [
            'detected' => true,
            'terms' => ['andaval'],
        ],
        'tags' => ['leetspeak'],
    ],
    [
        'id' => 'obfuscated.andaval.repeated-letters',
        'text' => 'andavalll',
        'expect' => [
            'detected' => true,
            'terms' => ['andaval'],
        ],
        'tags' => ['repeated-letters'],
    ],
    [
        'id' => 'obfuscated.andaval.spaces',
        'text' => 'a n d a v a l',
        'expect' => [
            'detected' => true,
            'terms' => ['andaval'],
        ],
        'tags' => ['separator-chain'],
    ],
    [
        'id' => 'obfuscated.yarrak.leetspeak',
        'text' => 'y4rr4k',
        'expect' => [
            'detected' => true,
            'terms' => ['yarrak'],
        ],
        'tags' => ['leetspeak'],
    ],
    [
        'id' => 'obfuscated.yarrak.spaces',
        'text' => 'y a r r a k',
        'expect' => [
            'detected' => true,
            'terms' => ['yarrak'],
        ],
        'tags' => ['separator-chain'],
    ],
    [
        'id' => 'obfuscated.yarrak.repeated-letters',
        'text' => 'yarrakkk',
        'expect' => [
            'detected' => true,
            'terms' => ['yarrak'],
        ],
        'tags' => ['repeated-letters'],
    ],
    [
        'id' => 'obfuscated.yarrak.dots',
        'text' => 'y.a.r.r.a.k',
        'expect' => [
            'detected' => true,
            'terms' => ['yarrak'],
        ],
        'tags' => ['separator-chain'],
        'note' => 'yarak spelling variant (yarak key) remains undetected — see edge.yarrak.yarak-gap',
    ],
    [
        'id' => 'obfuscated.amcik.ascii-fold',
        'text' => 'amcik',
        'expect' => [
            'detected' => true,
            'terms' => ['amcık'],
        ],
        'tags' => ['turkish-chars'],
    ],
    [
        'id' => 'obfuscated.amcik.leetspeak',
        'text' => '4mc1k',
        'expect' => [
            'detected' => true,
            'terms' => ['amcık'],
        ],
        'tags' => ['leetspeak', 'turkish-chars'],
    ],
    [
        'id' => 'obfuscated.amcik.spaces',
        'text' => 'a m c i k',
        'expect' => [
            'detected' => true,
            'terms' => ['amcık'],
        ],
        'tags' => ['separator-chain', 'turkish-chars'],
        'note' => 'amcıq → amciq remains undetected without a separate row',
    ],
    [
        'id' => 'obfuscated.fahise.ascii-fold',
        'text' => 'fahise',
        'expect' => [
            'detected' => true,
            'terms' => ['fahişe'],
        ],
        'tags' => ['turkish-chars'],
    ],
    [
        'id' => 'obfuscated.fahise.leetspeak',
        'text' => 'f4hise',
        'expect' => [
            'detected' => true,
            'terms' => ['fahişe'],
        ],
        'tags' => ['leetspeak', 'turkish-chars'],
    ],
    [
        'id' => 'obfuscated.fahise.spaces',
        'text' => 'f a h i s e',
        'expect' => [
            'detected' => true,
            'terms' => ['fahişe'],
        ],
        'tags' => ['separator-chain', 'turkish-chars'],
    ],
    [
        'id' => 'obfuscated.sktr.leetspeak',
        'text' => '5ktr',
        'expect' => [
            'detected' => true,
            'terms' => ['sktr'],
        ],
        'tags' => ['leetspeak', 'abbreviation'],
    ],
    [
        'id' => 'obfuscated.sktr.dots',
        'text' => 's.k.t.r',
        'expect' => [
            'detected' => true,
            'terms' => ['sktr'],
        ],
        'tags' => ['separator-chain', 'abbreviation'],
    ],
    [
        'id' => 'obfuscated.sktr.repeated-letters',
        'text' => 'sktrrr',
        'expect' => [
            'detected' => true,
            'terms' => ['sktr'],
        ],
        'tags' => ['repeated-letters', 'abbreviation'],
    ],
];
