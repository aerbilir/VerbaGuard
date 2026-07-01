# VerbaGuard Foundation

This document defines the long-term principles, boundaries, and quality bar for VerbaGuard. It is the authoritative reference for architectural and correctness decisions. For implementation details, see [`docs/specification.md`](docs/specification.md).

---

## Mission

VerbaGuard is a framework-independent PHP reference implementation for language-aware text moderation.

Primary goals:

- **Correctness** — reliable detection with minimal false positives
- **Deterministic behavior** — same input always yields the same result
- **Minimal runtime overhead** — zero Composer runtime dependencies
- **Extensibility** — language-specific behavior through profiles
- **Small package size** — focused core, no bundled megadictionaries
- **Readability** — code contributors can understand without deep context
- **Framework independence** — no Laravel, Symfony, or framework coupling

---

## Architecture Principles

- **Language-aware normalization** — global pipeline with profile-specific rules
- **Language profiles** — dictionaries and normalizers live in `LanguageProfile` implementations
- **Small focused classes** — composition over inheritance
- **Immutable value objects** where appropriate (results, matches)
- **No unnecessary abstractions** — prefer one clear class over orchestration layers
- **Specification-first** — behavioral contracts live in `docs/specification.md`

### Pipeline overview

```text
Raw text
  → Unicode normalize
  → Language-specific normalize
  → Leetspeak normalize
  → Repeated letter collapse
  → Matcher (exact token + separator spelled-chain)
  → Deduplicate overlaps
  → Score
  → AnalysisResult
```

---

## Correctness Policy

Correctness has higher priority than features.

Priority order:

1. Correctness
2. Tests
3. API stability
4. Performance
5. New features

**False positives are worse than false negatives.**

Do not ship features that trade precision for recall. When in doubt, prefer not matching over matching innocuous text.

The matcher (v2.2) is **frozen**. Changes are limited to bug fixes with regression tests. New matching strategies require a separate design phase and explicit approval.

---

## Matcher Principles

The matcher uses two deterministic paths only:

1. **Exact token matching** — tokenize letter/digit runs, normalize each token, exact dictionary lookup
2. **Separator spelled-chain matching** — concatenate single-letter runs separated by punctuation/whitespace, normalize the full chain, exact dictionary lookup

There is no:

- compact substring search
- normalized full-string substring search
- approximate or proportional offset mapping
- sub-chain enumeration inside spelled chains

Matches report **byte-accurate spans** into the original UTF-8 input for masking and inspection.

---

## Public API Boundary

### Supported (public)

| Symbol | Role |
|--------|------|
| `VerbaGuard` | Entry point: `analyze`, `contains`, `mask`, `score` |
| `AnalysisResult` | Structured analysis output |
| `ProfanityMatch` | Individual match metadata and byte span |
| `LanguageProfile` | Extension interface for new languages |
| `Dictionary` / `Entry` | Dictionary construction and lookup |
| `Severity` | Severity enum and scoring weights |
| `TurkishProfile` | Built-in Turkish language profile |
| `Normalizer` | Extension interface for profile normalizers |

### Internal (unsupported)

| Symbol | Role |
|--------|------|
| `Pipeline` | Orchestrates analysis per profile |
| `Matcher` | Token and spelled-chain matching |
| `TextSegments` / `SegmentRun` | Single-pass text segmentation |
| `Scorer` | Aggregates match severities |
| `NormalizationPipeline` | Applies normalizer chain |
| Concrete normalizers | `UnicodeNormalizer`, `TurkishNormalizer`, etc. |

Internal classes may change without semver notice. Integrate only through the public API.

---

## Performance Principles

- Zero runtime Composer dependencies
- Low memory allocations
- Predictable O(n) passes over input where practical
- No reflection in hot paths
- Avoid heavy regex when simpler solutions exist

---

## Dictionary Policy

- Dictionaries ship as plain PHP arrays (e.g. `data/tr.php`)
- Seed dictionaries stay **minimal** — for testing and demonstration, not production moderation at scale
- Production deployments should supply curated dictionaries via custom `LanguageProfile` implementations
- Short terms (e.g. `mal`, `aq`) increase false-positive risk in real-world text; dictionary curation is a product concern, not a matcher defect

---

## Testing Standards

- Every behavior change includes tests
- Regression tests for fixed bugs are mandatory
- False-positive and false-negative scenarios are equally important
- Tests must be deterministic

---

## Open Source Standards

- README and specification must match implementation
- Never document features that do not exist
- Conventional Commits for all changes
- MIT license
- Contributor Covenant for community conduct
- Security issues reported privately (see `SECURITY.md`)

---

## Related Documents

| Document | Purpose |
|----------|---------|
| [`README.md`](README.md) | Project overview and quick start |
| [`docs/specification.md`](docs/specification.md) | Behavioral specification |
| [`CONTRIBUTING.md`](CONTRIBUTING.md) | How to contribute |
| [`CHANGELOG.md`](CHANGELOG.md) | Version history |
| [`.cursor/instructions.md`](.cursor/instructions.md) | Development guide for contributors and automation |
