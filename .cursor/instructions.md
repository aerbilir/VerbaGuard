# VerbaGuard — AI Development Guide

This document is an **AI-assisted contributor guide** for automated development workflows on this repository. It is **not required reading for human contributors** — humans should start with [CONTRIBUTING.md](CONTRIBUTING.md).

Long-term architectural principles live in [FOUNDATION.md](FOUNDATION.md). Behavioral contracts live in [docs/specification.md](docs/specification.md). This file must not contradict those sources.

---

# Project Mission

VerbaGuard is a framework-independent PHP reference implementation for language-aware text moderation.

Primary goals:

- **Framework-independent** — no Laravel, Symfony, or framework coupling
- **Language-aware** — behavior injected through `LanguageProfile` implementations
- **Deterministic** — same input always yields the same `AnalysisResult`
- **Minimal runtime footprint** — zero Composer runtime dependencies
- **Correctness** — false positives are worse than false negatives

---

# Architecture Principles

- **Specification-first** — behavioral changes belong in `docs/specification.md` before or alongside implementation
- **Simplicity over cleverness** — prefer readable code over abstractions
- **Deterministic behavior** — no heuristics that vary between runs
- **Explainable algorithms** — matches must be inspectable via `ProfanityMatch`
- **Minimal public API** — extend through profiles, dictionaries, and `Normalizer` only
- **Zero unnecessary abstractions** — one clear class over orchestration layers
- **Backward compatibility** — public API changes require semver consideration

---

# Correctness Policy

Correctness has higher priority than features.

Priority order:

1. Correctness
2. Tests
3. API stability
4. Performance
5. New features

Core rules:

- **False positives are worse than false negatives.**
- **Matcher is frozen (v2.2).** Changes are bug-fix only.
- **Every matcher bug fix requires a regression test.**
- **Precision must never be traded for recall.**

---

# Public API

Supported public API is defined in [FOUNDATION.md](FOUNDATION.md) and [README.md](README.md). Integrate through these symbols only:

**Public (stable)**

- `VerbaGuard`
- `AnalysisResult`
- `ProfanityMatch`
- `Severity`
- `LanguageProfile`
- `Dictionary`
- `Entry`
- `TurkishProfile`
- `Normalizer` (interface)

**Internal (unsupported)**

- `Pipeline`
- `Matcher`
- `TextSegments`
- `Scorer`
- `NormalizationPipeline`
- Concrete normalizers

Internal namespaces are **not extension points**. They may change without semver notice.

Public APIs should remain backward compatible whenever reasonably possible. Avoid breaking changes unless absolutely necessary.

---

# Matcher Principles

Matcher v2.2 uses two deterministic paths:

1. **Exact token matching** — tokenize, normalize, exact dictionary lookup
2. **Separator spelled-chain matching** — full-chain equality after normalization

Rules:

- No compact matching
- No substring matching
- No approximate offset mapping
- Byte-accurate spans into original UTF-8 input
- Deterministic output for identical input

See [FOUNDATION.md](FOUNDATION.md) for the full matcher policy.

---

# Performance Principles

Always prefer:

- zero runtime dependencies
- low memory allocations
- predictable execution
- O(n) algorithms where practical
- avoiding unnecessary copies
- avoiding reflection
- avoiding heavy regex when simpler solutions exist

**Note:** `preg_match_all` for tokenization is an accepted design choice. Do not pursue premature optimization.

---

# Git Commit Standards

VerbaGuard uses the [Conventional Commits](https://www.conventionalcommits.org/) specification.

Format:

```
<type>: <summary>
```

Allowed types:

- feat
- fix
- refactor
- perf
- test
- docs
- chore
- ci

Rules:

- imperative mood
- concise summary (prefer under 72 characters)
- lowercase type
- no period at end of summary
- describe the capability added or changed, not filenames or implementation details
- no references to AI tools or assistants
- one logical change per commit
- avoid generic messages: `update`, `changes`, `fixes`, `work`, `misc`, `wip`

Examples:

```
feat: support Turkish language profile
fix: reject separator false positive
test: add regression for spelled-chain matching
docs: align specification with matcher v2.2
refactor: simplify normalization pipeline
perf: reduce allocations in token matching
ci: add PHP test workflow
chore: configure code style tools
```

Before creating a commit:

- inspect staged files
- determine the primary purpose of the change
- detect unrelated changes
- split into multiple commits when unrelated concerns are mixed
- otherwise produce exactly one Conventional Commit message

---

# Testing

Every behavior change should include tests.

Prefer deterministic tests.

Always add regression tests for fixed bugs.

False positive and false negative scenarios are equally important.

Additional rules:

- **Matcher changes require regression tests** — no matcher bug fix without a test
- **False positive tests must not be neglected** — they are as important as true positives
- **UTF-8 span validation must be preserved** — verify `start()` and `length()` byte accuracy

---

# Documentation

Documentation hierarchy (highest authority first):

1. **[FOUNDATION.md](FOUNDATION.md)** — architectural principles and API boundaries
2. **[docs/specification.md](docs/specification.md)** — behavioral contract
3. **[README.md](README.md)** — user-facing documentation
4. **[CHANGELOG.md](CHANGELOG.md)** — user-visible changes per release
5. **[CONTRIBUTING.md](CONTRIBUTING.md)** — contribution workflow
6. **[SECURITY.md](SECURITY.md)** — security policy
7. **This file** — AI contributor guide

Never document features that do not exist. README and specification must match implementation.

---

# Open Source

Prefer maintainability over clever code.

Write code that contributors can understand.

Document important architectural decisions.

Keep contributor onboarding simple.

Also follow:

- [CONTRIBUTING.md](CONTRIBUTING.md) — contribution workflow and commit standards
- [CODE_OF_CONDUCT.md](CODE_OF_CONDUCT.md) — community conduct
- [SECURITY.md](SECURITY.md) — private vulnerability reporting
- GitHub issue templates (`.github/ISSUE_TEMPLATE/`)
- Pull request template (`.github/pull_request_template.md`)

---

# Project-Specific AI Guidance

The following decisions are specific to VerbaGuard:

- **Framework-independent** — do not add framework dependencies or coupling
- **Language profiles** — dictionaries and profile normalizers belong in `LanguageProfile`, not in global pipeline code
- **Specification-first** — update `docs/specification.md` when behavior changes
- **Small seed dictionaries** — ship minimal plain PHP arrays; do not add megadictionaries to core
- **Explainable results** — `AnalysisResult` and `ProfanityMatch` must remain transparent; masking preserves non-matching text

### A) Analysis Pipeline

```text
Matcher
  ↓
Deduplicate overlaps
  ↓
Score
  ↓
AnalysisResult
```

`Pipeline` orchestrates this per `LanguageProfile`. Multiple profiles merge matches before deduplication.

### B) Normalization Order (inside Matcher)

Normalization applies to **each token candidate and each spelled-chain candidate** — not to the full input text as a preprocessing step.

```text
Unicode normalization
  ↓
Language profile normalization
  ↓
Leetspeak normalization
  ↓
Repeated-letter collapse
  ↓
Exact dictionary lookup
```

---

# Dictionary Curation

False-positive behavior from short terms (e.g. `mal`, `aq`) is a **dictionary design** and **language profile** concern — not a matcher defect.

Production deployments must supply curated dictionaries. Do not attempt to fix standalone-token matches by changing the frozen matcher.

---

# Unicode

`ext-intl` is **not required** but **recommended** for Unicode NFC normalization. Without it, visually equivalent Unicode forms may not match consistently.

---
