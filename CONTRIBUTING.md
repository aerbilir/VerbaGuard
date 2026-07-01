# Contributing to VerbaGuard

Thank you for your interest in VerbaGuard. This project values focused, well-tested contributions that preserve correctness and API stability.

## Before You Start

Read these documents:

- [FOUNDATION.md](FOUNDATION.md) — project principles and API boundaries
- [docs/specification.md](docs/specification.md) — behavioral contract
- [.cursor/instructions.md](.cursor/instructions.md) — development guide

**Matcher is frozen.** Matching logic changes are limited to confirmed bugs with regression tests. New matching strategies require a separate design discussion.

## Development Setup

```bash
git clone https://github.com/aerbilir/VerbaGuard.git
cd VerbaGuard
composer install
composer test
```

Requirements: PHP 8.2+, `ext-mbstring`. `ext-intl` is recommended.

## Pull Request Workflow

1. Open an issue for non-trivial changes (bugs, features, spec updates).
2. Fork the repository and create a branch from `main`.
3. Make focused changes — one logical concern per pull request.
4. Add or update tests for behavior changes.
5. Update documentation when behavior or public API changes.
6. Ensure `composer test` passes.
7. Open a pull request using the template.

## Commit Messages

VerbaGuard uses [Conventional Commits](https://www.conventionalcommits.org/):

```
<type>: <summary>
```

Allowed types: `feat`, `fix`, `refactor`, `perf`, `test`, `docs`, `chore`, `ci`

Examples:

```
fix: reject spelled-chain sub-group false positive
docs: align specification with matcher v2.2
test: add regression case for malzeme token boundary
ci: add PHP 8.3 to test matrix
```

## Code Guidelines

- Framework-independent — no Laravel, Symfony, or framework dependencies
- Public API changes require semver consideration and changelog entry
- Do not depend on internal classes (`Pipeline`, `Matcher`, etc.) from tests meant to demonstrate public usage
- False-positive regression tests are as important as true-positive tests
- Prefer simple, readable code over abstractions

## Reporting Bugs

Use the [bug report issue template](.github/ISSUE_TEMPLATE/bug_report.yml). Include:

- PHP version
- Input text (redact if needed)
- Expected vs actual behavior
- Minimal reproduction

## Security

Do not open public issues for security vulnerabilities. See [SECURITY.md](SECURITY.md).

## Code of Conduct

This project follows the [Contributor Covenant](CODE_OF_CONDUCT.md). By participating, you agree to uphold it.
