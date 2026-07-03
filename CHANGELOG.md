# Changelog

All notable changes to this project are documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [0.2.0] - 2026-07-03

Dictionary infrastructure release — author-only dictionary rows with build-time normalized key generation.

### Added

- `DictionaryBuilder` for build-time dictionary construction with `normalizeKey` injection
- Build-time normalized key generation: lookup keys are derived from `term` via `normalizeKey` at dictionary build time
- `Dictionary::fromRows()` as the canonical dictionary factory
- Author-only dictionary format: each row contains `term`, `category`, and `severity` only
- `tests/DictionaryTest.php` unit tests for dictionary authoring and validation (12 tests)

### Changed

- `Entry::fromRow()` replaces `Entry::fromArray()` for internal row construction
- Turkish seed dictionary (`data/tr.php`) migrated to author-only format
- `TurkishProfile` builds its dictionary via `NormalizationPipeline` so index keys match runtime normalization
- `docs/specification.md` and `README.md` updated for v0.2 dictionary authoring

### Removed

- `Dictionary::fromArray()` — use `Dictionary::fromRows($rows, $normalizeKey)` instead
- `Entry::fromArray()`

### Breaking changes

- `Dictionary::fromArray()` removed; custom `LanguageProfile` implementations must use `Dictionary::fromRows()` with a `normalizeKey` callable
- Author dictionary rows no longer accept a `normalized` field; including it throws `InvalidArgumentException` at build time

## [0.1.0] - 2026-07-01

Initial public release of VerbaGuard — a framework-independent PHP moderation engine for language-aware text analysis.

### Added

- Core `VerbaGuard` API: `analyze`, `contains`, `mask`, `score`
- `TurkishProfile` with seed dictionary and Turkish-specific normalization
- Language-aware normalization pipeline (Unicode NFC, leetspeak, repeated-letter collapse)
- Deterministic matcher v2.2 with exact token matching and separator spelled-chain matching
- `AnalysisResult` and `ProfanityMatch` value objects with byte-accurate UTF-8 spans
- False-positive and false-negative regression test suite (51 tests)
- GitHub Actions CI (PHP 8.2, PHP 8.3)
- OSS documentation and contribution files: `FOUNDATION.md`, `CONTRIBUTING.md`, `SECURITY.md`, `CODE_OF_CONDUCT.md`, `docs/RELEASE.md`
- Issue and pull request templates

### Changed

- Specification aligned with matcher v2.2 behavior
- README expanded for public release

[Unreleased]: https://github.com/aerbilir/VerbaGuard/compare/v0.2.0...HEAD
[0.2.0]: https://github.com/aerbilir/VerbaGuard/compare/v0.1.0...v0.2.0
[0.1.0]: https://github.com/aerbilir/VerbaGuard/releases/tag/v0.1.0
