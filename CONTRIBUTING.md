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

## Turkish Dictionary Quality Corpus

VerbaGuard maintains a fixture-based Turkish quality corpus under `tests/Fixtures/tr/`.

- **Clean corpus** — false-positive candidates (`expect.detected: false`)
- **Profane / obfuscated corpus** — detection cases (`expect.detected: true`)
- **Edge cases** — boundary behavior with explicit expectations

Quality gate (CI): false positives = 0, false negatives = 0, detection coverage = 100%.

### Adding corpus cases

1. Use stable `id` values (`category.slug`) unique across all fixture files.
2. Required fields: `id`, `text`, `expect.detected`.
3. Set `expect.terms` to seed dictionary terms only when asserting canonical matches.
4. Empty `text` is allowed only in `edge_cases.php`.
5. Run `composer test` — `TurkishCorpusQualityTest` must pass.

### Dictionary expansion PRs

Before adding Turkish dictionary entries, read [docs/dictionary-expansion-policy.md](docs/dictionary-expansion-policy.md).

New TR entry PRs **must** include:

- Clean neighbor cases (false-positive documentation)
- Profane and obfuscated positive cases
- A risk assessment in the PR description
- Passing aggregate corpus gate (FP = 0)

Do not add dictionary entries without corresponding corpus coverage.

### v0.4 Turkish lexicon expansion (three-PR workflow)

Controlled Turkish dictionary expansion in v0.4 is split across three pull requests. Do not combine policy, research, and implementation in a single PR.

| PR | Purpose | Changes allowed |
|----|---------|-----------------|
| **PR 1 — Documentation and policy** | Inline taxonomy, severity guidance, Batch 1 rules | Policy docs only — no dictionary or code changes |
| **PR 2 — Research and curation** | Candidate pool, maintainer evaluation, Approved Batch 1 list | Research document only — no `data/tr.php` or fixture changes |
| **PR 3 — Implementation** | Approved entries and corpus | `data/tr.php` + fixture corpus for exactly 15 approved entries |

**Maintainer review is required.** PR 3 may only implement entries explicitly approved in PR 2 (Stage 3 — Approved Batch 1). Do not auto-generate dictionary rows from research output.

**Corpus-first workflow.** Every approved entry must have a corpus plan before implementation. PR 3 must include clean neighbor, profane, and obfuscated cases per [docs/dictionary-expansion-policy.md](docs/dictionary-expansion-policy.md) before merge.

**Offensive language in contributions.** Research and fixture PRs may reference offensive terms when necessary for moderation quality. Follow these expectations:

- Summarize usage patterns — do not paste large blocks of raw user-generated content.
- Fixture cases must be minimal, purposeful, and tied to detection or false-positive documentation.
- Offensive fixture additions require maintainer review.
- Do not scrape or store raw comment archives in the repository.

See [docs/dictionary-expansion-policy.md](docs/dictionary-expansion-policy.md) for category taxonomy, Batch 1 acceptance criteria, and the three-stage curation workflow.

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
