# VerbaGuard

VerbaGuard is a framework-independent PHP reference implementation for language-aware text moderation.

It ships with zero runtime Composer dependencies, a small footprint, and an explainable analysis pipeline that normalizes text before matching so obfuscated profanity is easier to catch.

## Why language-aware normalization?

Profanity filters that only lowercase ASCII text miss common evasion patterns:

- Turkish-specific characters (`ş`, `ı`, `ğ`, …)
- Leetspeak (`4mk`, `@mk`)
- Repeated letters (`ammmmK`)
- Separator tricks (`s.i.k.t.i.r`, `s i k t i r`)

VerbaGuard applies a shared global pipeline and plugs in language-specific rules through `LanguageProfile` implementations.

## Installation

```bash
composer require verbaguard/verbaguard
```

Requirements:

- PHP 8.2+
- `ext-mbstring`

## Basic usage

```php
use VerbaGuard\VerbaGuard;

$guard = VerbaGuard::turkish();

$guard->contains('hello');          // false
$guard->score('amk');               // int
$guard->mask('bu bir amk test');    // bu bir *** test
$result = $guard->analyze('amk');   // AnalysisResult
```

## Turkish usage

```php
$guard = VerbaGuard::turkish();

$guard->contains('SİKTİR');     // true
$guard->contains('s.i.k.t.i.r'); // true
$guard->contains('4mk');          // true

$result = $guard->analyze('amk');

$result->hasProfanity(); // true
$result->score();         // 25
$result->severity();      // medium
$result->matches();       // ProfanityMatch[]
$result->masked('*');     // *** 
```

## Custom language profile

```php
use VerbaGuard\Contracts\LanguageProfile;
use VerbaGuard\Dictionary\Dictionary;
use VerbaGuard\Normalizer\Normalizer;
use VerbaGuard\VerbaGuard;

final class ExampleProfile implements LanguageProfile
{
    public function code(): string
    {
        return 'ex';
    }

    public function dictionary(): Dictionary
    {
        return Dictionary::fromArray([
            [
                'term' => 'badword',
                'normalized' => 'badword',
                'category' => 'profanity',
                'severity' => 'medium',
            ],
        ]);
    }

    public function normalizers(): array
    {
        return [
            new class implements Normalizer {
                public function normalize(string $text): string
                {
                    return mb_strtolower($text, 'UTF-8');
                }
            },
        ];
    }
}

$guard = VerbaGuard::forLanguages([
    new ExampleProfile(),
]);
```

## Small package / no runtime dependencies

- No Laravel or Symfony requirement
- No runtime Composer packages
- Small seed dictionary in `data/tr.php`
- PSR-4 autoloading from `src/`

## Roadmap

- Additional language profiles
- Pluggable scoring policies
- Optional bundled dictionaries
- Framework adapters (Laravel, Symfony) as separate packages

## Contributing

Contributions are welcome. Please keep changes focused, readable, and small. See `docs/specification.md` for pipeline and extension details.

## Offensive language notice

This repository contains a minimal seed dictionary with explicit profanity and insults for automated testing only. The words are intentionally offensive and are included solely to verify detection, scoring, and masking behavior. Do not use them outside test contexts.

## License

MIT. See [LICENSE](LICENSE).
