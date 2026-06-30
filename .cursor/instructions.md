# VerbaGuard — AI Development Guide

This document defines the official development principles for VerbaGuard. It applies to all contributors and automated development workflows working on this repository.

---

# Project Mission

VerbaGuard is a framework-independent PHP reference implementation for language-aware text moderation.

Primary goals:

- correctness
- deterministic behavior
- minimal runtime overhead
- extensibility
- small package size
- readability
- framework independence

---

# Architecture Principles

- Language-aware normalization
- Global pipeline
- Language profiles
- Small focused classes
- Immutable value objects where appropriate
- Composition over inheritance
- SOLID where it improves clarity
- No unnecessary abstractions
- No premature optimization

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

---

# Correctness Policy

Correctness has higher priority than features.

Priority order:

1. correctness
2. tests
3. API stability
4. performance
5. new features

False positives are worse than false negatives.

Do not introduce new features until correctness issues are resolved.

---

# Public API

Public APIs should remain backward compatible whenever reasonably possible.

Avoid breaking changes unless absolutely necessary.

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
fix: improve compact matcher offset mapping
refactor: simplify normalization pipeline
perf: optimize dictionary matcher
docs: expand project specification
test: add repeated-letter normalization tests
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

---

# Documentation

README must always reflect the current implementation.

Specification must match implementation.

Never document features that do not exist.

---

# Open Source

Prefer maintainability over clever code.

Write code that contributors can understand.

Document important architectural decisions.

Keep contributor onboarding simple.

---

# Project-Specific AI Guidance

The following decisions are specific to VerbaGuard and should guide all development on this repository:

- **Framework-independent** — VerbaGuard is not a Laravel, Symfony, or framework-specific package. Do not add framework dependencies or coupling.
- **Language profiles** — Language-specific behavior (normalization rules, dictionaries) belongs in `LanguageProfile` implementations, not in the global pipeline.
- **Normalization pipeline** — The global pipeline order is fixed: Unicode normalize → language-specific normalize → leetspeak → repeated letter collapse → compact normalize (matching only) → dictionary matcher → score → result.
- **Specification-first mindset** — Behavioral changes should be reflected in `docs/specification.md` before or alongside implementation. The spec is the contract.
- **Small seed dictionaries** — Dictionaries stay minimal and ship as plain PHP arrays. Do not add large dictionary files to the core package.
- **Explainable results** — Analysis output (`AnalysisResult`, `ProfanityMatch`) must remain transparent and inspectable. Masking must preserve non-matching text.
