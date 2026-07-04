# Batch 1 Turkish Lexicon Research and Curation

This document supports v0.4 Batch 1 Turkish lexicon expansion. It is a planning and curation artifact — not a dictionary file.

For expansion policy, taxonomy, and quality gates, see [`docs/dictionary-expansion-policy.md`](dictionary-expansion-policy.md).

**Status:** Structure prepared — research not yet performed.

---

## Purpose

This document prepares the researched candidate pool for v0.4 Batch 1 before any dictionary entries are added to [`data/tr.php`](../data/tr.php).

The goal is to separate **discovery** (broad candidate research) from **implementation** (exactly 15 high-confidence, corpus-backed entries in PR 3). Research fills Stage 1; maintainer curation completes Stages 2 and 3. PR 3 may only implement entries listed in Stage 3 — Approved Batch 1.

---

## Scope

This document covers **research and curation only**.

| In scope | Out of scope |
|----------|--------------|
| Candidate pool research summaries | Dictionary changes (`data/tr.php`) |
| Maintainer evaluation and approval | Corpus fixture changes |
| Risk and corpus planning per candidate | Matcher, dictionary infrastructure, or public API changes |
| PR 3 readiness checklist | Raw user-generated content archives |
| | Automatic dictionary generation or commit |

---

## Research Method

Research for this document will use **agent-reach** in a follow-up step for high-level Turkish usage pattern research. No research results are recorded yet.

### Intended research contexts

| Context | Focus |
|---------|--------|
| Turkish gaming/chat usage | Broad profanity and abbreviation patterns in live chat |
| Twitch/YouTube comment style | Common evasion and obfuscation in video comments |
| Turkish Reddit/forum-style discourse | Frequency vs niche slang; standalone token usage |
| Common Turkish internet abbreviations | High-confidence short forms; collision risk |
| Obfuscation/evasion patterns | Leetspeak, separators, Turkish character folding |
| False positive and normalized collision risks | Substring neighbors; overlap with existing seed entries |

Research output at each stage must follow the [Research discipline](#research-discipline) rules below.

---

## Research Discipline

1. **Summarize patterns** — do not paste large offensive comment blocks into this document or the repository.
2. **Do not scrape or store raw UGC** — no raw comment archives, dumps, or scraped post collections.
3. **Do not auto-commit entries from research** — research informs curation; maintainer approves final rows.
4. **Maintainer curates final entries** — only Stage 3 Approved Batch 1 entries may enter PR 3.
5. **Slur terms are out of scope for v0.4** — do not add slur-category candidates.
6. **No new ≤2 character entries in Batch 1** — prefer ≥4 character terms where possible.

---

## Stage 1 — Candidate Pool

Approximately **30–40 candidates** will be collected here after research. Table is empty until research is performed.

| ID | Candidate term | Category | Likely severity | FP risk | Collision risk | Usage evidence summary | Corpus plan | Notes |
|----|----------------|----------|-----------------|---------|----------------|------------------------|-------------|-------|
| | | | | | | | | |

**Category values:** `profanity`, `insult`, `sexual`, `abbreviation`

**Severity values:** `low`, `medium`, `high`

**Risk values:** `low`, `medium`, `high`

---

## Stage 2 — Maintainer Evaluation

Every Stage 1 candidate must be classified here with a short rationale.

| Candidate ID | Status | Rationale |
|--------------|--------|-----------|
| | | |

**Allowed statuses:**

| Status | Meaning |
|--------|---------|
| **Recommended** | Strong fit for Batch 1; passes selection rules |
| **Deferred** | Potentially valid; postponed (risk, collision, evidence gap) |
| **Rejected** | Does not meet acceptance criteria |

---

## Stage 3 — Approved Batch 1

Maintainer selects **exactly 15 entries** from the **Recommended** group only. PR 3 may only use these approved entries.

| Approved ID | Candidate term | Category | Severity | Corpus requirement summary | Approval notes |
|-------------|----------------|----------|----------|----------------------------|----------------|
| | | | | | |

**Approval gate:** Exactly **15** rows must be present and signed off before PR 3 begins.

**Maintainer approval recorded:** _Not yet — pending research and curation._

---

## Deferred Candidates

Candidates classified as **Deferred** in Stage 2. Copied here for tracking and future reconsideration.

| Candidate ID | Candidate term | Reason for deferral | Reconsideration condition |
|--------------|----------------|---------------------|---------------------------|
| | | | |

---

## Rejected Candidates

Candidates classified as **Rejected** in Stage 2. Copied here for audit trail.

| Candidate ID | Candidate term | Reason for rejection |
|--------------|----------------|----------------------|
| | | |

---

## PR3 Readiness Checklist

PR 3 cannot start until all items below are satisfied:

- [ ] Candidate pool contains approximately 30–40 entries
- [ ] Every candidate classified (Recommended / Deferred / Rejected)
- [ ] Exactly 15 approved entries in Stage 3
- [ ] No slur entries
- [ ] No new ≤2 character entries
- [ ] Every approved entry has a corpus plan
- [ ] FP risk documented for every approved entry
- [ ] Normalized collision risk checked against existing dictionary and other candidates
- [ ] Maintainer approval recorded

---

## Related documents

| Document | Purpose |
|----------|---------|
| [`docs/dictionary-expansion-policy.md`](dictionary-expansion-policy.md) | Taxonomy, Batch 1 rules, corpus requirements |
| [`docs/specification.md`](specification.md) | Dictionary author format |
| [`CONTRIBUTING.md`](../CONTRIBUTING.md) | Three-PR expansion workflow |
| [`tests/Fixtures/tr/README.md`](../tests/Fixtures/tr/README.md) | Corpus fixture format |
