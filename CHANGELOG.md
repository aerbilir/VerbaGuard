# Changelog

All notable changes to this project are documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added

- Matcher v2.2: exact token matching and separator spelled-chain matching
- `TextSegments` internal helper for byte-accurate span segmentation
- Regression test suite for false-positive and false-negative scenarios
- `FOUNDATION.md` project principles document
- GitHub Actions CI (PHP 8.2, 8.3)
- OSS documentation: `CONTRIBUTING.md`, `SECURITY.md`, `CODE_OF_CONDUCT.md`
- Issue and pull request templates

### Changed

- Specification updated for Matcher v2.2 (removed compact/substring matching)
- README expanded for public release

### Removed

- Compact substring matching path
- Normalized full-string substring search
- Approximate/proportional offset mapping

## [0.1.0] - TBD

Initial public release.

- Core `VerbaGuard` API: `analyze`, `contains`, `mask`, `score`
- `TurkishProfile` with seed dictionary
- Global normalization pipeline (Unicode, leetspeak, repeated letters)
- `AnalysisResult` and `ProfanityMatch` value objects
- Pest test suite

[Unreleased]: https://github.com/aerbilir/VerbaGuard/compare/v0.1.0...HEAD
[0.1.0]: https://github.com/aerbilir/VerbaGuard/releases/tag/v0.1.0
