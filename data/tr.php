<?php

declare(strict_types=1);

/**
 * Turkish seed dictionary for VerbaGuard. Author rows contain term, category,
 * and severity only; normalized keys are derived at build time.
 *
 * Contains a minimal set of offensive terms for testing purposes only.
 * See README.md offensive language notice.
 */
return [
    [
        'term' => 'amk',
        'category' => 'profanity',
        'severity' => 'medium',
    ],
    [
        'term' => 'aq',
        'category' => 'profanity',
        'severity' => 'low',
    ],
    [
        'term' => 'siktir',
        'category' => 'profanity',
        'severity' => 'high',
    ],
    [
        'term' => 'orospu',
        'category' => 'profanity',
        'severity' => 'high',
    ],
    [
        'term' => 'mal',
        'category' => 'insult',
        'severity' => 'low',
    ],
];
