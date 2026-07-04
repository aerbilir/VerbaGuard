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
    [
        'id' => 'profane.gerizekali.direct',
        'text' => 'gerizekalı',
        'expect' => [
            'detected' => true,
            'terms' => ['gerizekalı'],
        ],
        'tags' => ['direct'],
    ],
    [
        'id' => 'profane.gerizekali.sentence',
        'text' => 'sen gerizekalı mısın',
        'expect' => [
            'detected' => true,
            'terms' => ['gerizekalı'],
        ],
        'tags' => ['sentence'],
    ],
    [
        'id' => 'profane.gerizekali.uppercase',
        'text' => 'GERİZEKALI',
        'expect' => [
            'detected' => true,
            'terms' => ['gerizekalı'],
        ],
        'tags' => ['case-variant', 'turkish-chars'],
    ],
    [
        'id' => 'profane.dangalak.direct',
        'text' => 'dangalak',
        'expect' => [
            'detected' => true,
            'terms' => ['dangalak'],
        ],
        'tags' => ['direct'],
    ],
    [
        'id' => 'profane.dangalak.sentence',
        'text' => 'ne dangalak bir hareket',
        'expect' => [
            'detected' => true,
            'terms' => ['dangalak'],
        ],
        'tags' => ['sentence'],
    ],
    [
        'id' => 'profane.dangalak.team-blame',
        'text' => 'dangalak oynuyorsun',
        'expect' => [
            'detected' => true,
            'terms' => ['dangalak'],
        ],
        'tags' => ['sentence'],
    ],
    [
        'id' => 'profane.pezevenk.direct',
        'text' => 'pezevenk',
        'expect' => [
            'detected' => true,
            'terms' => ['pezevenk'],
        ],
        'tags' => ['direct'],
    ],
    [
        'id' => 'profane.pezevenk.sentence',
        'text' => 'tam bir pezevenk',
        'expect' => [
            'detected' => true,
            'terms' => ['pezevenk'],
        ],
        'tags' => ['sentence'],
    ],
    [
        'id' => 'profane.pezevenk.uppercase',
        'text' => 'PEZEVENK',
        'expect' => [
            'detected' => true,
            'terms' => ['pezevenk'],
        ],
        'tags' => ['case-variant'],
    ],
    [
        'id' => 'profane.salak.direct',
        'text' => 'salak',
        'expect' => [
            'detected' => true,
            'terms' => ['salak'],
        ],
        'tags' => ['direct'],
    ],
    [
        'id' => 'profane.salak.sentence',
        'text' => 'salak mısın sen',
        'expect' => [
            'detected' => true,
            'terms' => ['salak'],
        ],
        'tags' => ['sentence'],
    ],
    [
        'id' => 'profane.salak.insult-frame',
        'text' => 'bu salak işi bırak',
        'expect' => [
            'detected' => true,
            'terms' => ['salak'],
        ],
        'tags' => ['sentence'],
    ],
    [
        'id' => 'profane.kahpe.direct',
        'text' => 'kahpe',
        'expect' => [
            'detected' => true,
            'terms' => ['kahpe'],
        ],
        'tags' => ['direct'],
    ],
    [
        'id' => 'profane.kahpe.sentence',
        'text' => 'seni kahpe',
        'expect' => [
            'detected' => true,
            'terms' => ['kahpe'],
        ],
        'tags' => ['sentence'],
    ],
    [
        'id' => 'profane.kahpe.betrayal-frame',
        'text' => 'kahpe çıktın',
        'expect' => [
            'detected' => true,
            'terms' => ['kahpe'],
        ],
        'tags' => ['sentence'],
    ],
    [
        'id' => 'profane.kaltak.direct',
        'text' => 'kaltak',
        'expect' => [
            'detected' => true,
            'terms' => ['kaltak'],
        ],
        'tags' => ['direct'],
    ],
    [
        'id' => 'profane.kaltak.sentence',
        'text' => 'kaltak gibi davranma',
        'expect' => [
            'detected' => true,
            'terms' => ['kaltak'],
        ],
        'tags' => ['sentence'],
    ],
    [
        'id' => 'profane.kaltak.uppercase',
        'text' => 'KALTAK',
        'expect' => [
            'detected' => true,
            'terms' => ['kaltak'],
        ],
        'tags' => ['case-variant'],
    ],
    [
        'id' => 'profane.surtuk.direct',
        'text' => 'sürtük',
        'expect' => [
            'detected' => true,
            'terms' => ['sürtük'],
        ],
        'tags' => ['direct', 'turkish-chars'],
    ],
    [
        'id' => 'profane.surtuk.sentence',
        'text' => 'sürtük gibi giyinmiş',
        'expect' => [
            'detected' => true,
            'terms' => ['sürtük'],
        ],
        'tags' => ['sentence', 'turkish-chars'],
    ],
    [
        'id' => 'profane.surtuk.insult-frame',
        'text' => 'hey sürtük',
        'expect' => [
            'detected' => true,
            'terms' => ['sürtük'],
        ],
        'tags' => ['sentence', 'turkish-chars'],
    ],
    [
        'id' => 'profane.serefsiz.direct',
        'text' => 'şerefsiz',
        'expect' => [
            'detected' => true,
            'terms' => ['şerefsiz'],
        ],
        'tags' => ['direct', 'turkish-chars'],
    ],
    [
        'id' => 'profane.serefsiz.sentence',
        'text' => 'tam bir şerefsiz',
        'expect' => [
            'detected' => true,
            'terms' => ['şerefsiz'],
        ],
        'tags' => ['sentence', 'turkish-chars'],
    ],
    [
        'id' => 'profane.serefsiz.ascii-fold',
        'text' => 'serefsiz',
        'expect' => [
            'detected' => true,
            'terms' => ['şerefsiz'],
        ],
        'tags' => ['direct', 'turkish-chars'],
    ],
    [
        'id' => 'profane.gavat.direct',
        'text' => 'gavat',
        'expect' => [
            'detected' => true,
            'terms' => ['gavat'],
        ],
        'tags' => ['direct'],
    ],
    [
        'id' => 'profane.gavat.sentence',
        'text' => 'gavat herif',
        'expect' => [
            'detected' => true,
            'terms' => ['gavat'],
        ],
        'tags' => ['sentence'],
    ],
    [
        'id' => 'profane.gavat.uppercase',
        'text' => 'GAVAT',
        'expect' => [
            'detected' => true,
            'terms' => ['gavat'],
        ],
        'tags' => ['case-variant'],
    ],
    [
        'id' => 'profane.dalyarak.direct',
        'text' => 'dalyarak',
        'expect' => [
            'detected' => true,
            'terms' => ['dalyarak'],
        ],
        'tags' => ['direct'],
    ],
    [
        'id' => 'profane.dalyarak.sentence',
        'text' => 'ne dalyarak adamsın',
        'expect' => [
            'detected' => true,
            'terms' => ['dalyarak'],
        ],
        'tags' => ['sentence'],
    ],
    [
        'id' => 'profane.dalyarak.insult-frame',
        'text' => 'dalyarak gibi konuşma',
        'expect' => [
            'detected' => true,
            'terms' => ['dalyarak'],
        ],
        'tags' => ['sentence'],
    ],
    [
        'id' => 'profane.andaval.direct',
        'text' => 'andaval',
        'expect' => [
            'detected' => true,
            'terms' => ['andaval'],
        ],
        'tags' => ['direct'],
    ],
    [
        'id' => 'profane.andaval.sentence',
        'text' => 'andaval mısın',
        'expect' => [
            'detected' => true,
            'terms' => ['andaval'],
        ],
        'tags' => ['sentence'],
    ],
    [
        'id' => 'profane.andaval.uppercase',
        'text' => 'ANDAVAL',
        'expect' => [
            'detected' => true,
            'terms' => ['andaval'],
        ],
        'tags' => ['case-variant'],
    ],
    [
        'id' => 'profane.yarrak.direct',
        'text' => 'yarrak',
        'expect' => [
            'detected' => true,
            'terms' => ['yarrak'],
        ],
        'tags' => ['direct'],
    ],
    [
        'id' => 'profane.yarrak.sentence',
        'text' => 'yarrak gibi davranma',
        'expect' => [
            'detected' => true,
            'terms' => ['yarrak'],
        ],
        'tags' => ['sentence'],
    ],
    [
        'id' => 'profane.yarrak.uppercase',
        'text' => 'YARRAK',
        'expect' => [
            'detected' => true,
            'terms' => ['yarrak'],
        ],
        'tags' => ['case-variant'],
    ],
    [
        'id' => 'profane.amcik.direct',
        'text' => 'amcık',
        'expect' => [
            'detected' => true,
            'terms' => ['amcık'],
        ],
        'tags' => ['direct', 'turkish-chars'],
    ],
    [
        'id' => 'profane.amcik.sentence',
        'text' => 'amcık gibi hareket etme',
        'expect' => [
            'detected' => true,
            'terms' => ['amcık'],
        ],
        'tags' => ['sentence', 'turkish-chars'],
    ],
    [
        'id' => 'profane.amcik.ascii-fold',
        'text' => 'amcik',
        'expect' => [
            'detected' => true,
            'terms' => ['amcık'],
        ],
        'tags' => ['direct', 'turkish-chars'],
    ],
    [
        'id' => 'profane.fahise.direct',
        'text' => 'fahişe',
        'expect' => [
            'detected' => true,
            'terms' => ['fahişe'],
        ],
        'tags' => ['direct', 'turkish-chars'],
    ],
    [
        'id' => 'profane.fahise.sentence',
        'text' => 'fahişe gibi davranma',
        'expect' => [
            'detected' => true,
            'terms' => ['fahişe'],
        ],
        'tags' => ['sentence', 'turkish-chars'],
    ],
    [
        'id' => 'profane.fahise.ascii-fold',
        'text' => 'fahise',
        'expect' => [
            'detected' => true,
            'terms' => ['fahişe'],
        ],
        'tags' => ['direct', 'turkish-chars'],
    ],
    [
        'id' => 'profane.sktr.direct',
        'text' => 'sktr',
        'expect' => [
            'detected' => true,
            'terms' => ['sktr'],
        ],
        'tags' => ['direct', 'abbreviation'],
    ],
    [
        'id' => 'profane.sktr.gaming-frame',
        'text' => 'sktr git',
        'expect' => [
            'detected' => true,
            'terms' => ['sktr'],
        ],
        'tags' => ['sentence', 'abbreviation'],
    ],
    [
        'id' => 'profane.sktr.uppercase',
        'text' => 'SKTR',
        'expect' => [
            'detected' => true,
            'terms' => ['sktr'],
        ],
        'tags' => ['case-variant', 'abbreviation'],
    ],
];
