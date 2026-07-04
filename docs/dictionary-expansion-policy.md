# Turkish Dictionary Expansion Policy

This document defines the quality gate, inline taxonomy, and maintainer workflow for adding or changing Turkish dictionary entries in VerbaGuard.

For corpus format and test infrastructure, see [`tests/Fixtures/tr/README.md`](../tests/Fixtures/tr/README.md).

For dictionary author format, see [`docs/specification.md`](specification.md).

---

## Principles

1. **False positives are worse than false negatives** — see [`FOUNDATION.md`](../FOUNDATION.md).
2. **Corpus before expansion** — measurable quality ground must exist before growing the dictionary.
3. **Short terms need extra care** — tokens of three characters or fewer have higher false-positive risk in real text.
4. **Quality over volume** — expansion success is measured by corpus-backed confidence and zero false positives, not by entry count.

---

## Inline taxonomy (v0.4)

VerbaGuard v0.4 uses four supported dictionary categories. Category definitions live in this document. A separate taxonomy reference file (`docs/turkish-lexicon-taxonomy.md`) is intentionally **deferred** until the Turkish dictionary reaches approximately **100 curated entries**.

### `profanity`

- **Definition:** General profanity and vulgar slang where profanity is the dominant intent (not a personal insult).
- **Example types:** Verb roots, common standalone profanity tokens.
- **Typical severity:** `medium`–`high`
- **False-positive risk:** Medium

### `insult`

- **Definition:** Personal degradation — attacks on worth, competence, or identity.
- **Example types:** Standalone insult adjectives (prefer ≥4 characters).
- **Typical severity:** `low`–`medium`
- **False-positive risk:** High — substring collisions with innocent words are common.

### `sexual`

- **Definition:** Explicit sexual slang or sexual profanity.
- **Example types:** Sexual organ or act slang (prefer ≥4 characters, clearly standalone).
- **Typical severity:** `medium`–`high`
- **False-positive risk:** Medium — medical or biological substring risk.

### `abbreviation`

- **Definition:** High-confidence abbreviation of profanity or insult; normalized form must be unique in the dictionary.
- **Example types:** Chat abbreviations, short forms related to an existing entry.
- **Typical severity:** `low`–`medium`
- **False-positive risk:** Very high — use sparingly; only when collision risk is low.

### Explicitly excluded: `slur`

> Slur moderation is a distinct moderation domain with additional ethical, cultural, and review requirements. It is intentionally **out of scope for v0.4**. Reconsider in a later major/minor roadmap after a separate ethical, cultural, and review policy is defined.

Do not add slur-category terms in v0.4 expansion work.

---

## Severity guidance

Severity reflects moderation urgency, not term frequency. Category does **not** automatically determine severity.

| Severity | Score | Usage criteria |
|----------|-------|----------------|
| `low` | 10 | Lower aggression; precedent: existing `aq`, `mal` |
| `medium` | 25 | Clear profanity; standalone token (`amk`) |
| `high` | 50 | Severe profanity or explicit sexual slang (`siktir`, `orospu`) |

Rules:

1. Assign severity based on moderation impact, not how often a term appears online.
2. Document severity rationale in research and PR risk assessments.
3. The severity enum is fixed — see [`src/Severity.php`](../src/Severity.php).

---

## v0.4 expansion workflow (three PRs)

Turkish lexicon expansion in v0.4 follows a controlled three-pull-request sequence:

| PR | Scope | Dictionary / code changes |
|----|-------|---------------------------|
| **PR 1** | Policy and taxonomy documentation | None |
| **PR 2** | Research and curation | None |
| **PR 3** | Approved entries + corpus | `data/tr.php` + fixtures |

PR 3 cannot start until maintainer approval of the Batch 1 entry list from PR 2.

---

## Batch 1 acceptance policy

Batch 1 adds exactly **15** high-confidence Turkish entries in a single implementation PR (PR 3).

### Target distribution (flexible — planning guidance only)

These numbers are planning guidance, not hard quotas. Research may justify a different category mix when supported by evidence.

| Category | Target (flexible) |
|----------|-------------------|
| `profanity` | ≈ 6 |
| `insult` | ≈ 3 |
| `sexual` | ≈ 4 |
| `abbreviation` | ≈ 2 |
| `slur` | **0** |

Maintainer approval may adjust category counts based on real-world frequency, false-positive risk, normalized collisions, corpus quality, and research evidence. Total implementation size remains exactly **15 entries**.

### Selection rules

- Prefer **≥4 character** terms.
- **No new ≤2 character** entries in Batch 1.
- Avoid ambiguous common words unless strongly justified with clean neighbor coverage.
- Abbreviations: high-confidence only, low normalized-collision risk.
- Prefer **broad online usage** over niche slang.
- Every candidate must have a **corpus plan** before PR 3 approval.
- Do not copy large amounts of raw offensive user-generated content into the repository.

### Entry acceptance criteria

An entry may enter PR 3 only when all of the following hold:

1. Listed in PR 2 research as **Approved Batch 1** (selected from the Recommended group).
2. Canonical `term` with a unique normalized key (build-time check via `DictionaryBuilder`).
3. Category ∈ {`profanity`, `insult`, `sexual`, `abbreviation`}.
4. **Not** ≤2 characters (Batch 1 rule).
5. Not an ambiguous common word without strong justification and clean neighbors.
6. Corpus complete per minimum table below.
7. Aggregate quality gate passes (FP = 0, FN = 0, coverage = 100%).
8. PR risk assessment block filled (template below).

**Automatic reject:** slur-category terms, new ≤2 character entries, normalized key collision, false-positive gate failure.

---

## Maintainer review workflow (PR 2 curation)

Research should maximize **discovery**. Implementation should maximize **quality**. The candidate pool is larger than the implementation batch.

### Stage 1 — Candidate pool

- Collect approximately **30–40 candidate terms** through research.
- Summarize usage patterns at a high level — do not archive raw user comments in the repository.

### Stage 2 — Maintainer evaluation

Classify every candidate as **Recommended**, **Deferred**, or **Rejected**. Each classification must include a short rationale.

| Status | Meaning |
|--------|---------|
| **Recommended** | Strong fit for Batch 1; passes selection rules |
| **Deferred** | Potentially valid; postponed (risk, collision, evidence gap) |
| **Rejected** | Does not meet acceptance criteria |

### Stage 3 — Approved Batch 1

- Maintainer selects exactly **15 entries** from the **Recommended** group only.
- Final list includes category, severity, false-positive/collision assessment, and corpus plan per entry.
- **PR 3 may only use these 15 approved entries.**

### Research output format (per candidate)

| Field | Description |
|-------|-------------|
| Canonical term (proposed) | Maintainer-facing; high-level in research doc |
| Category | profanity / insult / sexual / abbreviation |
| Likely severity | low / medium / high + rationale |
| FP risk | low / medium / high |
| Normalized collision risk | vs existing entries + other candidates |
| Corpus plan | min profane / obfuscated / clean counts |
| Classification rationale | Reason for Recommended / Deferred / Rejected |

### Approval gate

PR 2 is complete when the research document includes all three stages and exactly **15 Approved Batch 1** entries are signed off. PR 3 cannot begin until this gate passes.

---

## Pre-merge checklist for new TR entries

Before merging a pull request that adds or changes Turkish dictionary rows:

1. Add **clean neighbor cases** documenting false-positive risk.
2. Add **profane detection cases** for the new term (direct usage).
3. Add **obfuscated detection cases** where evasion is realistic (leetspeak, separators, Turkish folding).
4. Ensure the aggregate corpus gate passes:
   - false positives = **0**
   - false negatives = **0**
   - detection coverage = **100%** (profane + obfuscated corpus)
5. Include a **risk assessment** in the PR description (template below).

Do not merge dictionary expansion PRs that increase false positives without explicit project approval.

---

## Clean neighbor cases (required)

Every new entry must include clean corpus cases showing the term does **not** match innocuous text.

| Term length | Minimum clean neighbor cases |
|-------------|------------------------------|
| ≤2 characters | 8 |
| 3 characters | 5 |
| ≥4 characters | 3 |

Neighbor cases should cover:

- Substring collisions (term embedded in longer innocent words)
- Similar spellings and Turkish character variants
- Realistic sentence context where the innocent word appears

Add cases to [`tests/Fixtures/tr/clean.php`](../tests/Fixtures/tr/clean.php) with `tags` and optional `risk`.

---

## Profane and obfuscated positive cases (required)

For each new entry, add:

- At least **3** cases to [`tests/Fixtures/tr/profane.php`](../tests/Fixtures/tr/profane.php) (direct token and sentence usage)
- At least **3** cases to [`tests/Fixtures/tr/obfuscated.php`](../tests/Fixtures/tr/obfuscated.php) (realistic evasion)

Each positive case should set `expect.terms` to the canonical dictionary term.

---

## Short-term evaluation (≤3 characters)

Short dictionary terms (e.g. `aq`, `mal`, `amk`) require:

- Explicit `risk` annotation on related clean cases
- Extra clean neighbor coverage per table above
- Documented trade-off in the PR risk assessment
- Reviewer acknowledgment that standalone-token matching is intentional

Short-term false positives are a **dictionary design** concern, not a matcher defect.

---

## False-positive gate

The CI quality gate enforced by [`tests/TurkishCorpusQualityTest.php`](../tests/TurkishCorpusQualityTest.php) requires:

```
falsePositiveCount() === 0
falseNegativeCount() === 0
detectionCoverage() === 100.0  // profane + obfuscated corpus
```

Any PR that increases false positives must either:

- Revise or reject the dictionary entry, or
- Add clean corpus cases proving the new behavior is acceptable (rare; requires explicit approval)

---

## Risk assessment template

Include this block in dictionary expansion PRs:

```markdown
## Dictionary entry risk assessment

- Term: `example`
- Length: 3
- Category / severity: profanity / medium
- Clean neighbors added: clean.example.* (5 cases)
- Profane cases added: profane.example.* (3 cases)
- Obfuscated cases added: obfuscated.example.* (3 cases)
- Known FP risk: [none | documented in corpus notes]
- Short-term trade-off: [N/A | standalone token may match innocuous text in edge contexts]
```

---

## Related documents

| Document | Purpose |
|----------|---------|
| [`FOUNDATION.md`](../FOUNDATION.md) | Correctness policy |
| [`docs/specification.md`](specification.md) | Dictionary author format |
| [`CONTRIBUTING.md`](../CONTRIBUTING.md) | Contribution workflow |
