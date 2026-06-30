# VerbaGuard Specification (v0.1)

This document describes the VerbaGuard moderation pipeline, extension points, and result format for the initial `0.1` release.

## Pipeline

Every analysis run follows the same global stages. Language-specific behavior is injected through `LanguageProfile`.

```text
Raw text
  → Unicode normalize
  → Language-specific normalize
  → Leetspeak normalize
  → Repeated letter collapse
  → Compact normalize (for compact matching only)
  → Dictionary matcher
  → Score
  → Result
```

The pipeline is global. Profiles provide:

- `code()`
- `dictionary()`
- `normalizers()`

## LanguageProfile format

```php
interface LanguageProfile
{
    public function code(): string;
    public function dictionary(): Dictionary;
    public function normalizers(): array;
}
```

- `code()` returns an ISO-style language identifier such as `tr`.
- `dictionary()` returns a `Dictionary` instance.
- `normalizers()` returns an ordered list of profile-specific `Normalizer` implementations.

## Dictionary format

Dictionaries are plain PHP arrays loaded from files such as `data/tr.php`.

Each entry contains:

| Field        | Description                                      |
|-------------|--------------------------------------------------|
| `term`      | Canonical dictionary term                        |
| `normalized`| Normalized form used for matching                |
| `category`  | Semantic category, e.g. `profanity`, `insult`    |
| `severity`  | One of `clean`, `low`, `medium`, `high`          |

Example:

```php
[
    'term' => 'amk',
    'normalized' => 'amk',
    'category' => 'profanity',
    'severity' => 'medium',
]
```

## Normalization stages

### Unicode normalize

Applies Unicode NFC normalization when the `intl` extension is available.

### Language-specific normalize

Provided by the active `LanguageProfile`.

Turkish profile rules:

- lowercase UTF-8
- `ç -> c`
- `ğ -> g`
- `ı -> i`
- `İ -> i`
- `ö -> o`
- `ş -> s`
- `ü -> u`

### Leetspeak normalize

Global map:

| Input | Output |
|------|--------|
| `0`  | `o`    |
| `1`  | `i`    |
| `!`  | `i`    |
| `3`  | `e`    |
| `4`  | `a`    |
| `@`  | `a`    |
| `5`  | `s`    |
| `$`  | `s`    |
| `7`  | `t`    |

### Repeated letter collapse

Three or more identical consecutive characters collapse to one. The rule is deterministic and applies to the full normalized string.

### Compact normalize

Whitespace, punctuation, and separator characters are removed from the normalized string. This helps detect patterns such as `s.i.k.t.i.r` and `s i k t i r`.

## Matching behavior

Matching runs in two modes:

1. **Word-level matching** on normalized text
   - tokenizes letter/digit runs from the original text
   - normalizes each token through the same pipeline
   - also searches the full normalized string with simple boundary checks

2. **Compact matching** on the compact normalized string
   - finds dictionary terms in the compact form
   - maps compact spans back to approximate original byte ranges for masking

Perfect offset mapping is not required in v0.1, but masking must preserve non-matching text.

Overlapping matches are deduplicated before scoring.

## Scoring behavior

Severity weights:

| Severity | Score contribution |
|---------|-------------------|
| `clean` | 0                 |
| `low`   | 10                |
| `medium`| 25                |
| `high`  | 50                |

The final score is the sum of all unique match severities.

`AnalysisResult::severity()` returns the highest severity among matched terms. If there are no matches, severity is `clean`.

## Result format

### AnalysisResult

- `hasProfanity(): bool`
- `score(): int`
- `severity(): string`
- `matches(): array`
- `masked(string $mask = '*'): string`

### ProfanityMatch

- `original(): string`
- `normalized(): string`
- `term(): string`
- `language(): string`
- `category(): string`
- `severity(): string`
- `start(): int`
- `length(): int`

Offsets are byte offsets into the original UTF-8 input.

## Future compatibility notes

- New normalization stages should be added to the global pipeline, not to individual profiles, unless they are language-specific.
- Dictionary entries should remain array-based in v0.1-compatible formats so existing language files keep working.
- Additional severity levels or scoring policies should be introduced behind explicit interfaces in future versions.
- Framework adapters should live in separate packages and depend on this core library.
