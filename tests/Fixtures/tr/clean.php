<?php

declare(strict_types=1);

/**
 * Turkish clean corpus — false-positive candidates.
 *
 * Test-only innocuous text. See README.md in this directory.
 */
return [
    [
        'id' => 'clean.normal.word',
        'text' => 'normal',
        'expect' => ['detected' => false],
        'tags' => ['substring', 'mal-risk'],
        'note' => 'normal must not match mal via substring',
    ],
    [
        'id' => 'clean.animal.word',
        'text' => 'animal',
        'expect' => ['detected' => false],
        'tags' => ['substring', 'mal-risk'],
    ],
    [
        'id' => 'clean.formal.word',
        'text' => 'formal',
        'expect' => ['detected' => false],
        'tags' => ['substring', 'mal-risk'],
    ],
    [
        'id' => 'clean.small.word',
        'text' => 'small',
        'expect' => ['detected' => false],
        'tags' => ['substring', 'mal-risk'],
    ],
    [
        'id' => 'clean.malzeme.embedded',
        'text' => 'malzeme',
        'expect' => ['detected' => false],
        'tags' => ['substring', 'mal-risk'],
        'note' => 'mal must not match inside malzeme',
    ],
    [
        'id' => 'clean.malzeme.phrase',
        'text' => 'küçük malzeme',
        'expect' => ['detected' => false],
        'tags' => ['substring', 'mal-risk'],
    ],
    [
        'id' => 'clean.kamk.neighbor',
        'text' => 'kamk',
        'expect' => ['detected' => false],
        'tags' => ['substring', 'amk-risk'],
        'risk' => 'high',
    ],
    [
        'id' => 'clean.samk.neighbor',
        'text' => 'şamk',
        'expect' => ['detected' => false],
        'tags' => ['substring', 'amk-risk'],
        'risk' => 'high',
    ],
    [
        'id' => 'clean.greeting.merhaba',
        'text' => 'Merhaba dünya',
        'expect' => ['detected' => false],
        'tags' => ['sentence'],
    ],
    [
        'id' => 'clean.weather.sentence',
        'text' => 'Bugün hava güzel',
        'expect' => ['detected' => false],
        'tags' => ['sentence'],
    ],
    [
        'id' => 'clean.meeting.sentence',
        'text' => 'Toplantı saat üçte başlayacak',
        'expect' => ['detected' => false],
        'tags' => ['sentence'],
    ],
    [
        'id' => 'clean.delivery.sentence',
        'text' => 'Projeyi yarın teslim edeceğiz',
        'expect' => ['detected' => false],
        'tags' => ['sentence'],
    ],
    [
        'id' => 'clean.anormal.word',
        'text' => 'Anormal değerler görüldü',
        'expect' => ['detected' => false],
        'tags' => ['substring', 'mal-risk'],
    ],
    [
        'id' => 'clean.small.business',
        'text' => 'Small business model',
        'expect' => ['detected' => false],
        'tags' => ['substring', 'mal-risk'],
    ],
    [
        'id' => 'clean.formal.outfit',
        'text' => 'Formal giysi giydi',
        'expect' => ['detected' => false],
        'tags' => ['substring', 'mal-risk'],
    ],
    [
        'id' => 'clean.animal.documentary',
        'text' => 'Animal kingdom documentary',
        'expect' => ['detected' => false],
        'tags' => ['substring', 'mal-risk'],
    ],
    [
        'id' => 'clean.trafo.sentence',
        'text' => 'Trafo merkezi bakımda',
        'expect' => ['detected' => false],
        'tags' => ['sentence'],
    ],
    [
        'id' => 'clean.kapak.malzeme',
        'text' => 'Kapak malzemesi geldi',
        'expect' => ['detected' => false],
        'tags' => ['substring', 'mal-risk'],
    ],
    [
        'id' => 'clean.portakal.sentence',
        'text' => 'Portakal suyu içtim',
        'expect' => ['detected' => false],
        'tags' => ['sentence'],
    ],
    [
        'id' => 'clean.academic.sentence',
        'text' => 'Akademik çalışma tamamlandı',
        'expect' => ['detected' => false],
        'tags' => ['sentence'],
    ],
    [
        'id' => 'clean.engineering.sentence',
        'text' => 'Mühendislik fakültesi',
        'expect' => ['detected' => false],
        'tags' => ['sentence'],
    ],
    [
        'id' => 'clean.software.sentence',
        'text' => 'Yazılım güncellendi',
        'expect' => ['detected' => false],
        'tags' => ['sentence'],
    ],
    [
        'id' => 'clean.database.sentence',
        'text' => 'Veritabanı yedeklendi',
        'expect' => ['detected' => false],
        'tags' => ['sentence'],
    ],
    [
        'id' => 'clean.login.sentence',
        'text' => 'Kullanıcı giriş yaptı',
        'expect' => ['detected' => false],
        'tags' => ['sentence'],
    ],
    [
        'id' => 'clean.order.sentence',
        'text' => 'Sipariş onaylandı',
        'expect' => ['detected' => false],
        'tags' => ['sentence'],
    ],
    [
        'id' => 'clean.campaign.sentence',
        'text' => 'Kampanya başladı',
        'expect' => ['detected' => false],
        'tags' => ['sentence'],
    ],
    [
        'id' => 'clean.map.sentence',
        'text' => 'Harita güncellendi',
        'expect' => ['detected' => false],
        'tags' => ['sentence'],
    ],
    [
        'id' => 'clean.calendar.sentence',
        'text' => 'Takvim etkinliği eklendi',
        'expect' => ['detected' => false],
        'tags' => ['sentence'],
    ],
    [
        'id' => 'clean.autoreply.sentence',
        'text' => 'Otomatik yanıt açık',
        'expect' => ['detected' => false],
        'tags' => ['sentence'],
    ],
    [
        'id' => 'clean.programmatic.sentence',
        'text' => 'Programatik erişim kapalı',
        'expect' => ['detected' => false],
        'tags' => ['sentence'],
    ],
];
