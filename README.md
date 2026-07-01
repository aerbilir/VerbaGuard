# VerbaGuard

[![CI](https://github.com/aerbilir/VerbaGuard/actions/workflows/tests.yml/badge.svg)](https://github.com/aerbilir/VerbaGuard/actions/workflows/tests.yml)
[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE)

Framework-independent PHP library for language-aware text moderation.

VerbaGuard normalizes text, matches dictionary terms with deterministic exact matching, and returns explainable results — with zero runtime Composer dependencies.

> For project principles and long-term boundaries, see [FOUNDATION.md](FOUNDATION.md).

---

## What is VerbaGuard?

VerbaGuard is a small PHP moderation engine that detects profanity and insults in user-generated text. It is designed for applications that need:

- predictable, testable behavior
- language-specific normalization (Turkish out of the box)
- explainable matches with byte-accurate spans for masking
- no framework lock-in

It is a **reference implementation**, not a hosted moderation service. You bring your own dictionaries and integrate via a simple PHP API.

---

## Features

- **Zero runtime dependencies** — only PHP 8.2+ and `ext-mbstring`
- **Language profiles** — plug in dictionaries and normalizers per language
- **Turkish profile** — built-in seed dictionary and Turkish character normalization
- **Obfuscation resistance** — leetspeak, repeated letters, and separator tricks (`s.i.k.t.i.r`)
- **Exact matching** — no substring false positives from embedded terms
- **Explainable output** — `ProfanityMatch` objects with term, category, severity, and byte span
- **Masking** — preserve non-matching UTF-8 text around detected spans

---

## Installation

```bash
composer require verbaguard/verbaguard
```

**Requirements**

| Requirement | Notes |
|-------------|-------|
| PHP `^8.2` | Required |
| `ext-mbstring` | Required |
| `ext-intl` | Optional; enables Unicode NFC normalization |

---

## Quick Start

```php
use VerbaGuard\VerbaGuard;

$guard = VerbaGuard::turkish();

$guard->contains('hello');           // false
$guard->score('amk');                // 25
$guard->mask('bu bir amk test');     // bu bir *** test
$result = $guard->analyze('amk');     // AnalysisResult
```

### Inspect a result

```php
$result = $guard->analyze('SİKTİR');

$result->hasProfanity();  // true
$result->score();          // 50
$result->severity();       // high
$result->matches();        // ProfanityMatch[]
$result->masked('*');      // ******
```

### Obfuscation examples

```php
$guard->contains('s.i.k.t.i.r');  // true  — separator spelled-chain
$guard->contains('4mk');           // true  — leetspeak token
$guard->contains('malzeme');       // false — no embedded substring match
$guard->contains('n o r m a l');   // false — full chain is "normal"
```

---

## Public API

### `VerbaGuard`

| Method | Description |
|--------|-------------|
| `turkish(): self` | Guard with Turkish profile |
| `forLanguages(array $profiles): self` | Guard with custom profiles |
| `analyze(string $text): AnalysisResult` | Full analysis |
| `contains(string $text): bool` | Whether any match exists |
| `mask(string $text, string $mask = '*'): string` | Mask matched spans |
| `score(string $text): int` | Aggregate severity score |

### `AnalysisResult`

| Method | Description |
|--------|-------------|
| `hasProfanity(): bool` | Any matches found |
| `score(): int` | Sum of match severity weights |
| `severity(): string` | Highest match severity |
| `matches(): array` | List of `ProfanityMatch` |
| `masked(string $mask = '*'): string` | Masked original text |

### `ProfanityMatch`

| Method | Description |
|--------|-------------|
| `original(): string` | Matched substring |
| `normalized(): string` | Normalized lookup form |
| `term(): string` | Dictionary canonical term |
| `language(): string` | Profile code |
| `category(): string` | e.g. `profanity`, `insult` |
| `severity(): string` | `low`, `medium`, `high` |
| `start(): int` | Byte offset in original UTF-8 |
| `length(): int` | Byte length in original UTF-8 |

---

## Supported Public API

### Public (stable)

Integrate through these symbols only:

- `VerbaGuard\VerbaGuard`
- `VerbaGuard\AnalysisResult`
- `VerbaGuard\ProfanityMatch`
- `VerbaGuard\Severity`
- `VerbaGuard\Contracts\LanguageProfile`
- `VerbaGuard\Dictionary\Dictionary`
- `VerbaGuard\Dictionary\Entry`
- `VerbaGuard\Language\TurkishProfile`
- `VerbaGuard\Normalizer\Normalizer` (extension interface)

### Internal (unsupported)

Not part of the public contract. May change without notice:

- `VerbaGuard\Pipeline\Pipeline`
- `VerbaGuard\Pipeline\Matcher`
- `VerbaGuard\Pipeline\TextSegments`
- `VerbaGuard\Pipeline\Scorer`
- `VerbaGuard\Pipeline\NormalizationPipeline`
- Concrete normalizers (`UnicodeNormalizer`, `TurkishNormalizer`, `LeetspeakNormalizer`, etc.)

See [`docs/specification.md`](docs/specification.md) for full behavioral details.

---

## TurkishProfile

`TurkishProfile` is the built-in language profile for Turkish text moderation.

```php
use VerbaGuard\VerbaGuard;

$guard = VerbaGuard::turkish();
```

It provides:

- **Dictionary** — seed terms in `data/tr.php` (testing only; see offensive language notice below)
- **Normalization** — Turkish lowercase and ASCII folding (`ş→s`, `ı→i`, `ğ→g`, etc.)

Use `VerbaGuard::forLanguages()` with a custom profile when you need a production dictionary.

---

## Language Profiles

A language profile bundles a dictionary and profile-specific normalizers:

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

$guard = VerbaGuard::forLanguages([new ExampleProfile()]);
```

Multiple profiles can be passed; matches from all profiles are merged and deduplicated.

---

## Normalization Pipeline

Global stages run in fixed order for every token and spelled chain:

```text
Unicode NFC (when ext-intl available)
  → Language-specific normalizers (from profile)
  → Leetspeak map (4→a, @→a, 1→i, …)
  → Repeated letter collapse (aaa → a)
```

Normalization prepares text for **exact dictionary lookup**. It does not perform fuzzy or substring matching.

---

## Matcher Overview

The matcher (v2.2, frozen) uses two deterministic paths:

### 1. Exact token matching

Letter/digit runs are tokenized, normalized, and looked up with exact equality. `malzeme` does not match `mal`.

### 2. Separator spelled-chain matching

Single-letter runs separated by punctuation or spaces form a chain. The full concatenated chain is normalized and matched exactly. `s i k t i r` matches `siktir`; `n o r m a l` does not match `mal`.

**Policy:** false positives are worse than false negatives. Matches use byte-accurate spans — no approximate offset mapping.

---

## Philosophy

VerbaGuard prioritizes **correctness and explainability** over aggressive recall.

- Small, readable codebase over clever abstractions
- Deterministic behavior over heuristic tuning
- Framework independence over ecosystem coupling
- Curated dictionaries over megadictionary bundles
- Open, inspectable matches over black-box scores

See [FOUNDATION.md](FOUNDATION.md) for the full principles document.

---

## Performance Goals

- O(n) passes over input text
- No runtime Composer dependencies
- Minimal allocations in the hot path
- No reflection in matching
- Suitable for per-request moderation in web applications

Benchmarks are not published yet; performance work follows correctness and API stability.

---

## Known Limitations

- **Seed dictionary** — `data/tr.php` contains a minimal set of offensive terms for automated testing, not production moderation.
- **Short terms** — very short entries like `mal` or `aq` match when they appear as standalone tokens in otherwise innocent sentences.
- **`ext-intl` optional** — without it, Unicode NFC normalization is skipped.
- **No NLP context** — homonyms, sarcasm, and intent are not evaluated.

---

## Contributing

Contributions are welcome. Please read:

- [CONTRIBUTING.md](CONTRIBUTING.md) — workflow and commit standards
- [FOUNDATION.md](FOUNDATION.md) — project principles
- [docs/specification.md](docs/specification.md) — behavioral contract

Run tests before opening a pull request:

```bash
composer install
composer test
```

---

## Offensive Language Notice

This repository contains a minimal seed dictionary with explicit profanity and insults for automated testing only. The words are intentionally offensive and are included solely to verify detection, scoring, and masking behavior. Do not use them outside test contexts.

---

## License

MIT. See [LICENSE](LICENSE).
