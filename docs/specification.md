# VerbaGuard Specification

This document describes the VerbaGuard moderation pipeline, matching behavior, extension points, and result format. It is the behavioral contract for the library.

For project principles and API boundaries, see [`FOUNDATION.md`](../FOUNDATION.md).

---

## Pipeline

Every analysis run follows the same global stages. Language-specific behavior is injected through `LanguageProfile`.

```text
Raw text
  → Unicode normalize
  → Language-specific normalize
  → Leetspeak normalize
  → Repeated letter collapse
  → Matcher
  → Deduplicate overlapping matches
  → Score
  → AnalysisResult
```

The pipeline is global. Profiles provide:

- `code()`
- `dictionary()`
- `normalizers()`

---

## Supported Public API

### Public (stable)

These symbols are intended for downstream use. Breaking changes follow semantic versioning and appear in `CHANGELOG.md`.

| Symbol | Namespace |
|--------|-----------|
| `VerbaGuard` | `VerbaGuard\` |
| `AnalysisResult` | `VerbaGuard\` |
| `ProfanityMatch` | `VerbaGuard\` |
| `Severity` | `VerbaGuard\` |
| `LanguageProfile` | `VerbaGuard\Contracts\` |
| `Dictionary` | `VerbaGuard\Dictionary\` |
| `Entry` | `VerbaGuard\Dictionary\` |
| `TurkishProfile` | `VerbaGuard\Language\` |
| `Normalizer` | `VerbaGuard\Normalizer\` (extension interface) |

### Internal (unsupported)

These are implementation details. They are not covered by semver guarantees and may change without notice.

| Symbol | Namespace |
|--------|-----------|
| `Pipeline` | `VerbaGuard\Pipeline\` |
| `Matcher` | `VerbaGuard\Pipeline\` |
| `TextSegments` / `SegmentRun` | `VerbaGuard\Pipeline\` |
| `Scorer` | `VerbaGuard\Pipeline\` |
| `NormalizationPipeline` | `VerbaGuard\Pipeline\` |
| Concrete normalizers | `VerbaGuard\Normalizer\` |

Do not depend on internal classes. Extend the library through `LanguageProfile`, `Dictionary`, and `Normalizer` only.

---

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
- `normalizers()` returns an ordered list of profile-specific `Normalizer` implementations applied after Unicode normalization and before global leetspeak/repeated-letter stages.

---

## Dictionary format

Dictionaries are plain PHP arrays loaded from files such as `data/tr.php`.

### Author format (v0.2+)

Each author row contains only user-written canonical fields:

| Field       | Description                                   |
|------------|-----------------------------------------------|
| `term`     | Canonical dictionary term                     |
| `category` | Semantic category, e.g. `profanity`, `insult` |
| `severity` | One of `clean`, `low`, `medium`, `high`       |

Do **not** include `normalized` in author rows. It is derived at dictionary build time.

Example author row:

```php
[
    'term' => 'amk',
    'category' => 'profanity',
    'severity' => 'medium',
]
```

### Build-time construction

Use `Dictionary::fromRows()` with a `normalizeKey` callable. The callable must apply the same normalization chain the matcher uses at runtime (typically the profile's `NormalizationPipeline`).

```php
Dictionary::fromRows(
    rows: $rows,
    normalizeKey: fn (string $term): string => $normalization->normalize($term),
);
```

At build time, each `term` is passed through `normalizeKey` to produce the derived `normalized` lookup key stored on `Entry`.

### Runtime `Entry` fields

| Field        | Source   | Description                                      |
|-------------|----------|--------------------------------------------------|
| `term`      | Author   | Canonical dictionary term                        |
| `category`  | Author   | Semantic category                                |
| `severity`  | Author   | Severity level                                   |
| `normalized`| Derived  | Build-time normalized form used for matching     |

### Breaking changes in v0.2

- `Dictionary::fromArray()` removed — use `Dictionary::fromRows()` instead.
- Author dictionary rows no longer accept a `normalized` field.

---

## Normalization stages

Normalization runs per token or per spelled chain before dictionary lookup. Order is fixed.

### Unicode normalize

Applies Unicode NFC normalization when the `intl` extension is available. Without `intl`, input passes through unchanged (see Known limitations).

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

---

## Matching behavior

The matcher is **deterministic** and uses **exact equality** only. There is no substring search, compact matching, or approximate offset mapping.

**Correctness policy:** false positives are worse than false negatives.

### Path 1: Exact token matching

1. Tokenize the original text with `/[\p{L}\p{N}@$!]+/u` (letter, digit, and leetspeak symbol runs).
2. Normalize each token through the full normalization pipeline.
3. Look up the normalized form in the dictionary with exact key equality.
4. On match, record a `ProfanityMatch` with byte-accurate `start` and `length` from the original token span.

Examples:

| Input | Match | Reason |
|-------|-------|--------|
| `amk` | `amk` | Exact token |
| `4mk` | `amk` | Leetspeak normalization |
| `bu mal bir şey` | `mal` | Standalone insult token |
| `malzeme` | — | No exact token `mal` |

### Path 2: Separator spelled-chain matching

For obfuscation with separators between letters (e.g. `s.i.k.t.i.r`, `s i k t i r`):

1. Segment the original text into alternating letter runs and separator runs (`TextSegments`).
2. Build **spelled chains**: consecutive single-letter runs, with flush rules when a multi-character letter run appears.
3. Concatenate the letters in each chain, normalize the full chain, and look up with exact dictionary equality.
4. On match, span covers from the first chain run's byte start through the last chain run's byte end in the original text.

**No sub-chain enumeration.** Only the full spelled chain is tested. `n o r m a l` does not match `mal` because the normalized chain is `normal`, not `mal`.

Examples:

| Input | Match | Reason |
|-------|-------|--------|
| `s.i.k.t.i.r` | `siktir` | Full chain after normalization |
| `a m k` | `amk` | Full chain |
| `n o r m a l` | — | Chain normalizes to `normal` |
| `m a l` | `mal` | Full chain matches insult token |

### Deduplication

Overlapping matches from both paths are deduplicated before scoring. When spans overlap, the earlier/longer match is kept.

### Byte-accurate spans

`ProfanityMatch::start()` and `length()` are byte offsets into the original UTF-8 input. Masking uses these spans directly; there is no proportional or approximate mapping.

---

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

---

## Result format

### AnalysisResult

- `hasProfanity(): bool`
- `score(): int`
- `severity(): string`
- `matches(): array`
- `masked(string $mask = '*'): string`

### ProfanityMatch

- `original(): string` — matched substring from original input
- `normalized(): string` — normalized form used for lookup
- `term(): string` — canonical dictionary term
- `language(): string` — profile code
- `category(): string`
- `severity(): string`
- `start(): int` — byte offset in original UTF-8 text
- `length(): int` — byte length in original UTF-8 text

---

## Known limitations

- **Seed dictionary** — `data/tr.php` is minimal and for testing; production use requires curated dictionaries.
- **Short terms** — very short dictionary entries (e.g. `mal`, `aq`) can match in legitimate phrases when they appear as standalone tokens.
- **`intl` optional** — NFC normalization requires `ext-intl`; without it, visually equivalent Unicode forms may not match.
- **Single-pass analysis** — no context-aware NLP; each token/chain is evaluated independently.

---

## Future compatibility notes

- New normalization stages belong in the global pipeline unless language-specific.
- Dictionary author rows remain plain PHP arrays with `term`, `category`, and `severity`.
- Derived fields such as `normalized` are produced at build time via `Dictionary::fromRows()`.
- Additional severity levels or scoring policies require explicit interfaces in future versions.
- Framework adapters should live in separate packages depending on this core library.
- Matcher changes are bug-fix only while frozen; see `FOUNDATION.md`.
