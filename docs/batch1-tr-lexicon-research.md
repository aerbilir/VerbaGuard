# Batch 1 Turkish Lexicon Research and Curation

This document supports v0.4 Batch 1 Turkish lexicon expansion. It is a planning and curation artifact — not a dictionary file.

For expansion policy, taxonomy, and quality gates, see [`docs/dictionary-expansion-policy.md`](dictionary-expansion-policy.md).

**Status:** Maintainer curation complete — 2026-07-04. Ready for PR 3 implementation.

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

Research was performed in four parallel agent reports (no additional web research in this curation step):

| Report | Focus |
|--------|--------|
| [`docs/research/agent-1-gaming-chat.md`](research/agent-1-gaming-chat.md) | Gaming, Discord, Twitch, live-chat abbreviations and obfuscation |
| [`docs/research/agent-2-general-internet.md`](research/agent-2-general-internet.md) | Forums, social media, general Turkish internet insult/profanity lanes |
| [`docs/research/agent-3-fp-review.md`](research/agent-3-fp-review.md) | False-positive quality review (binding tie-break) |
| [`docs/research/agent-4-normalization.md`](research/agent-4-normalization.md) | Normalized-key collision and variant mapping review |

### Tie-break priority

When agents disagree, classifications follow this order:

1. **FP review** (Agent 3) — binding on standalone-token and normalization-collision FP
2. **Normalization review** (Agent 4) — binding on normalized-key uniqueness and variant mapping
3. **Research evidence** (Agents 1 + 2) — frequency, usage context, obfuscation patterns

Existing seed entries (`amk`, `aq`, `siktir`, `orospu`, `mal`) are baseline coverage — not re-proposed as new candidates.

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

**40 unique candidates** merged from Agents 1 and 2, evaluated by Agents 3 and 4. Seed duplicates excluded.

| ID | Canonical term | Category | Proposed severity | Confidence | FP risk | Normalization notes | Research source(s) |
|----|----------------|----------|-------------------|------------|---------|---------------------|-------------------|
| C01 | salak | insult | low | high | low | Key `salak` stable; leet `s4lak`, repetition, separators converge | A1, A2, A3, A4 |
| C02 | aptal | insult | low | high | high | Key `aptal` unique; `aptalca` is different token | A1, A2, A3, A4 |
| C03 | gerizekalı | insult | medium | high | low | Key `gerizekali`; reject `gerzek` as second row | A1, A2, A3, A4 |
| C04 | dangalak | insult | low | high | low | Key `dangalak` unique | A1, A3, A4 |
| C05 | yavşak | insult | medium | high | medium | Key `yavsak`; ASCII `yavsak` same key; zoological homonym | A1, A2, A3, A4 |
| C06 | şerefsiz | insult | medium | high | low–medium | Key `serefsiz` after fold | A1, A3, A4 |
| C07 | pezevenk | insult | medium | high | low | Key `pezevenk`; `pzvnk` truncation not covered | A1, A2, A3, A4 |
| C08 | andaval | insult | low | medium | low | Key `andaval` unique | A1, A3, A4 |
| C09 | gavat | insult | medium | high | low | Key `gavat` unique | A2, A3, A4 |
| C10 | dalyarak | insult | medium | high | low | Key `dalyarak` unique | A2, A3, A4 |
| C11 | piç | insult | medium | high | high | Key `pic` — **collision with English `pic`** | A1, A2, A3, A4 |
| C12 | kahpe | insult | medium | high | low | Key `kahpe` unique | A1, A2, A3, A4 |
| C13 | kaltak | sexual | medium | high | low | Key `kaltak` unique | A1, A3, A4 |
| C14 | sürtük | sexual | medium | high | low | Key `surtuk` after fold | A1, A2, A3, A4 |
| C15 | yarrak | sexual | high | high | medium | Key `yarrak`; defer `yarak`/`yrk` as separate rows | A1, A2, A3, A4 |
| C16 | yarak | sexual | high | medium | medium | Key `yarak` ≠ `yarrak` — duplicate intent | A1, A3, A4 |
| C17 | amcık | sexual | high | high | medium | Key `amcik`; `amcıq` → `amciq` not covered | A1, A2, A3, A4 |
| C18 | göt | sexual | medium | high | high | Key `got` — **collision with English `got`**; `6öt` leet gap | A1, A2, A3, A4 |
| C19 | puşt | sexual | medium | medium | low | Key `pust` after fold | A1, A3, A4 |
| C20 | kaşar | sexual | low | medium | high | Key `kasar` — **collision with cheese homograph** | A1, A3, A4 |
| C21 | fahişe | sexual | medium | medium | low–medium | Key `fahise`; historical-descriptive standalone use | A1, A3, A4 |
| C22 | sokayım | profanity | high | high | high | Key `sokayim`; innocent `sokmak` conjugation homonym | A2, A3, A4 |
| C23 | siktirgit | profanity | medium | medium | low | Key `siktirgit` distinct from seed `siktir` | A2, A3, A4 |
| C24 | lan | profanity | low | high | high | Key `lan` unique; ubiquitous particle standalone | A2, A3 |
| C25 | sokarım | profanity | high | medium | high | Key `sokarim`; innocent `sokmak` conjugation | A2, A3 |
| C26 | ananı | insult | high | medium | medium | Key `anani`; phrasal fragment | A2, A3 |
| C27 | aminakoyayim | profanity | high | medium | low | Long phrase token; poor standalone dictionary shape | A2, A3 |
| C28 | soktugum | profanity | high | low | medium | Morphological family too broad | A2, A3 |
| C29 | hassiktir | profanity | medium | medium | low | Key `hassiktir`; elongation of seed `siktir` | A2, A3, A4 |
| C30 | ibne | — | — | high | — | Slur-domain; v0.4 excluded | A1, A2, A3, A4 |
| C31 | sktr | abbreviation | medium | high | low | Key `sktr` ≠ `siktir`; requires own row | A1, A3, A4 |
| C32 | hsktir | abbreviation | medium | medium | low | Key `hsktir`; depends on `sktr` precedent | A1, A3, A4 |
| C33 | amq | abbreviation | medium | medium | medium | Key `amq`; 3-char; redundant with seed `amk`/`aq` | A1, A3, A4 |
| C34 | gerzek | insult | low | medium | low | Key `gerzek` ≠ `gerizekali`; semantic duplicate of C03 | A1, A3, A4 |
| C35 | pic | insult | medium | high | very high | ASCII duplicate of C11; same key `pic` | A2, A3 |
| C36 | amcığa | sexual | high | low | medium | Agglutinative fragment | A1, A3 |
| C37 | sikik | profanity | medium | medium | medium | Root overlap with seed `siktir` | A1, A3 |
| C38 | götlalesi | insult | medium | low | low | Niche compound meme insult | A2, A3 |
| C39 | godoş | insult | medium | medium | low | Dated in younger cohorts | A2, A3 |
| C40 | kezban | insult | low | medium | medium | Stereotype insult; given-name collision edge | A2, A3 |
| C41 | oç / mk / sg | abbreviation | — | high | very high | ≤2 characters; acronym storm — Batch 1 automatic reject | A1, A2, A3, A4 |

**Category values:** `profanity`, `insult`, `sexual`, `abbreviation`

**Severity values:** `low`, `medium`, `high`

**Risk values:** `low`, `medium`, `high`

---

## Stage 2 — Maintainer Evaluation

Every Stage 1 candidate classified below. Tie-breaks applied per Agent 3 (FP) then Agent 4 (normalization).

| Candidate ID | Status | Rationale |
|--------------|--------|-----------|
| C01 | **Recommended** | Both research agents + FP review agree; dominant everyday insult usage; standard clean corpus sufficient (see [A08 re-evaluation](#a08--salak)) |
| C02 | **Deferred** | Agent 3 binding: high meta-linguistic/educational standalone FP; Agent 1 deferred; normalization OK but FP gate not achievable |
| C03 | **Recommended** | Multi-source high confidence; unique key; reject `gerzek` sibling per normalization one-key rule |
| C04 | **Recommended** | Agent 1 + FP + normalization aligned; no innocent homograph |
| C05 | **Deferred** | Agent 3 binding: zoological standalone homonym (yavşak balığı); Agent 1 recommended overridden |
| C06 | **Recommended** | Agent 1 + FP aligned; formal-news adjective trade-off documented, acceptable |
| C07 | **Recommended** | Cross-source convergence; unique key; low FP |
| C08 | **Recommended** | Agent 3 promoted over Agent 1 deferral — fills insult slot with clean token shape |
| C09 | **Recommended** | Agent 2 + FP + normalization aligned; Ekşi salience; unique key |
| C10 | **Recommended** | Agent 2 + FP aligned; long token, low FP |
| C11 | **Deferred** | Agent 3 binding: `piç` → `pic` normalization collision with English `pic`; Agent 2 recommended overridden |
| C12 | **Recommended** | Both agents + FP aligned; categorized as `insult` (character betrayal register) |
| C13 | **Recommended** | Agent 1 + FP + normalization aligned |
| C14 | **Recommended** | Agent 3 FP overrides Agent 2 ethics deferral; low lexical FP |
| C15 | **Recommended** | Dominant sexual slang; canonical over `yarak`; obfuscation gaps documented in corpus |
| C16 | **Deferred** | Normalization: `yarak` ≠ `yarrak`; duplicate moderation intent — cover via C15 obfuscation corpus |
| C17 | **Recommended** | Both agents + FP aligned; distinct from seed `amk`/`aq` |
| C18 | **Deferred** | Agent 3 binding: `göt` → `got` English collision; 3-char; `6öt` leet pipeline gap |
| C19 | **Deferred** | Agent 1 ethics defer + borderline slur-adjacent; no urgent Batch 1 need |
| C20 | **Deferred** | Agent 3 binding: `kaşar` → `kasar` cheese homograph; normalization collision |
| C21 | **Recommended** | Agent 3 optional slot candidate; historical-descriptive FP manageable with extra clean frames |
| C22 | **Rejected** | Agent 3 binding: innocent `sokmak` conjugation homonym — FP gate unreachable; Agent 4 normalization OK irrelevant |
| C23 | **Deferred** | Compound token; semantic overlap with seed `siktir`; matcher design clarity first |
| C24 | **Deferred** | Ubiquitous particle standalone; 3-char; requires 8+ filler clean frames |
| C25 | **Deferred** | Morphological homonym of `sokmak`; same innocent-conjugation FP class as C22 |
| C26 | **Deferred** | Phrasal maternal insult fragment; phrase-aware matching not in v0.4 |
| C27 | **Deferred** | Phrase-level token; non-standard dictionary standalone shape |
| C28 | **Rejected** | Broad morphological family; low standalone precision |
| C29 | **Deferred** | Elongation of seed `siktir`; obfuscation corpus item, not new row |
| C30 | **Rejected** | Slur-domain; v0.4 policy exclusion |
| C31 | **Recommended** | Agent 4 normalization requires separate row; Agent 3 optional slot — promoted with abbreviation corpus gate (6 clean cases) |
| C32 | **Deferred** | Abbreviation class; defer until C31 passes one release cycle |
| C33 | **Deferred** | 3-char; redundant with seed `amk`/`aq` family |
| C34 | **Deferred** | Truncation duplicate of C03; one normalized key per intent |
| C35 | **Rejected** | Identical normalized key to innocent English `pic`; duplicate of C11 |
| C36 | **Rejected** | Agglutinative fragment; unstable standalone dictionary shape |
| C37 | **Rejected** | Root-family overlap with seed `siktir`; suffix-aware matching not in v0.4 |
| C38 | **Rejected** | Niche compound; low corpus ROI |
| C39 | **Rejected** | Dated register; declining usage |
| C40 | **Rejected** | Stereotype insult; given-name collision edge cases |
| C41 | **Rejected** | ≤2 characters; Batch 1 automatic reject per policy |

**Stage 2 totals:** Recommended **15** · Deferred **16** · Rejected **9**

---

## Stage 3 — Approved Batch 1

Maintainer selects **exactly 15 entries** from the **Recommended** group. PR 3 may only use these approved entries.

**Category mix:** insult ×8 · sexual ×6 · abbreviation ×1 · profanity ×0

Policy targets (≈6 profanity, ≈3 insult, ≈4 sexual, ≈2 abbreviation) are flexible guidance — see note below.

> **Why Batch 1 adds no new `profanity` entries**
>
> Batch 1 intentionally contains insults, sexual terms, and one abbreviation, but no new profanity rows. This is a quality decision, not a category omission.
>
> Every profanity candidate evaluated in research failed at least one v0.4 acceptance gate without an acceptable trade-off:
>
> - **`sokayım` / `sokarım`** — innocent first-person `sokmak` (insert/plug) conjugations share the same standalone token
> - **`lan`** — ubiquitous colloquial particle; high standalone-token FP despite high frequency
> - **`göt`** — normalized key `got` collides with English `got`; 3-character tier escalation unmet
> - **`siktirgit` / `hassiktir`** — semantic overlap with seeded `siktir`; compounds better handled as obfuscation corpus items
> - **`aminakoyayim`** — phrase-level token; poor standalone dictionary shape
>
> Core profanity coverage for v0.4 already exists in the seed dictionary (`amk`, `aq`, `siktir`, `orospu`). Batch 1 prioritizes net-new insult and sexual lanes where FP = 0 is achievable under exact-token matching. Profanity expansion resumes in a later batch when phrase-aware matching, mixed-language corpus lanes, or 3-character policy exceptions are available.

| Approved ID | Candidate term | Category | Severity | Corpus requirement summary | Approval notes |
|-------------|----------------|----------|----------|----------------------------|----------------|
| A01 | gerizekalı | insult | medium | ≥3 clean (+2 meta-linguistic), ≥3 profane, ≥3 obfuscated (ASCII fold, leet, `gerzek` gap note) | Canonical long form; do not add `gerzek` row; normalized key `gerizekali` |
| A02 | dangalak | insult | low | ≥3 clean, ≥3 profane, ≥3 obfuscated (leet, repetition, separators) | Unique key; teammate-blame gaming signal |
| A03 | pezevenk | insult | medium | ≥3 clean, ≥3 profane, ≥3 obfuscated (leet, separators; `pzvnk` gap note) | Cross-source convergence |
| A04 | şerefsiz | insult | medium | ≥3 clean (+2 formal-news frames), ≥3 profane, ≥3 obfuscated (ASCII fold `serefsiz`) | Accept formal adjective trade-off; context out of v0.4 NLP scope |
| A05 | gavat | insult | medium | ≥3 clean, ≥3 profane, ≥3 obfuscated | Relationship-shaming insult; Ekşi salience |
| A06 | dalyarak | insult | medium | ≥3 clean, ≥3 profane, ≥3 obfuscated (repetition) | Long token; very low innocent usage |
| A07 | andaval | insult | low | ≥3 clean, ≥3 profane, ≥3 obfuscated | Lower frequency but clean FP profile |
| A08 | salak | insult | low | ≥3 clean, ≥3 profane, ≥3 obfuscated (leet, repetition, separators) | Standard ≥4-char insult; see re-evaluation note |
| A09 | kahpe | insult | medium | ≥3 clean (+1 historical-literary), ≥3 profane, ≥3 obfuscated | Character betrayal insult register |
| A10 | kaltak | sexual | medium | ≥3 clean, ≥3 profane, ≥3 obfuscated (leet, repetition) | No common innocent homograph |
| A11 | sürtük | sexual | medium | ≥3 clean, ≥3 profane, ≥3 obfuscated (ASCII `surtuk` fold) | Agent 3 FP overrides ethics deferral |
| A12 | yarrak | sexual | high | ≥3 clean, ≥3 profane, ≥3 obfuscated (+2 `yarak`/dots/spaced; `yrk` gap note) | Prefer over `yarak`; high gaming + social volume |
| A13 | amcık | sexual | high | ≥3 clean (+2 fold-variant neighbors), ≥3 profane, ≥3 obfuscated (ASCII `amcik`, leet; `amcıq` gap note) | Distinct from seed `amk`/`aq` |
| A14 | fahişe | sexual | medium | ≥3 clean (+2 historical-descriptive), ≥3 profane, ≥3 obfuscated | Agent 3 optional slot; lower priority than A10–A13 |
| A15 | sktr | abbreviation | medium | ≥6 clean (+3 gaming handle/acronym frames), ≥3 profane, ≥3 obfuscated (`s.k.t.r`, leet `5ktr`, `sktr git` frame) | First abbreviation row; proves category in CI; distinct key from `siktir` |

**Approval gate:** Exactly **15** rows present and signed off.

**Maintainer approval recorded:** 2026-07-04 — Batch 1 approved for PR 3 implementation.

### Per-entry approval detail

#### A01 — `gerizekalı`

- **Category / severity:** insult / medium
- **Rationale:** Top-tier intelligence insult in ranked chat and forum arguments; unique normalized key; both research agents recommend.
- **Minimum corpus:** 3 clean (+2 quoted/meta frames), 3 profane, 3 obfuscated
- **Normalization:** Author term `gerizekalı` → key `gerizekali`; document `gerzek`/`glk` as detection gaps

#### A02 — `dangalak`

- **Category / severity:** insult / low
- **Rationale:** Frequent teammate-blame insult; no common innocent sense.
- **Minimum corpus:** 3 clean, 3 profane, 3 obfuscated
- **Normalization:** Stable ASCII key; leet `d4ng4lak` converges

#### A03 — `pezevenk`

- **Category / severity:** insult / medium
- **Rationale:** Stable standalone insult; discord-filter + terlik.js convergence.
- **Minimum corpus:** 3 clean, 3 profane, 3 obfuscated
- **Normalization:** `pzvnk` chat truncation not covered — obfuscated limitation note

#### A04 — `şerefsiz`

- **Category / severity:** insult / medium
- **Rationale:** Rage-chat character insult; distinct normalized key.
- **Minimum corpus:** 3 clean (+2 formal-news), 3 profane, 3 obfuscated
- **Normalization:** ASCII fold `serefsiz`; formal adjective usage is documented trade-off

#### A05 — `gavat`

- **Category / severity:** insult / medium
- **Rationale:** Persistent forum/social relationship-shaming insult; Ekşi 13p proxy.
- **Minimum corpus:** 3 clean, 3 profane, 3 obfuscated
- **Normalization:** Key `gavat` unique

#### A06 — `dalyarak`

- **Category / severity:** insult / medium
- **Rationale:** High-velocity escalatory insult in open comment sections.
- **Minimum corpus:** 3 clean, 3 profane, 3 obfuscated
- **Normalization:** Long token reduces abbreviation noise

#### A07 — `andaval`

- **Category / severity:** insult / low
- **Rationale:** Fills Batch 1 with lower FP than contested short tokens; clean token shape.
- **Minimum corpus:** 3 clean, 3 profane, 3 obfuscated
- **Normalization:** Key `andaval` unique

#### A08 — `salak`

- **Category / severity:** insult / low
- **Rationale:** Default competence insult across gaming and general internet; both agents agree.
- **Minimum corpus:** 3 clean, 3 profane, 3 obfuscated (standard ≥4-character minimum)
- **Normalization:** Key `salak` stable; leet, repetition, and separator variants converge
- **FP re-evaluation (maintainer, 2026-07-04):** Initial curation elevated FP risk because Agent 3 listed *salak balığı* as a zoological homonym. On review, that usage is niche ichthyology terminology — not a high-frequency standalone token in everyday Turkish text. Unlike `yavşak` (actively used as a common fish name in fishing and biology discourse), `salak` in modern usage is overwhelmingly the competence insult. VerbaGuard exact-token matching already prevents embedded-substring FPs (`salaklık`, compound forms). No normalization collision exists. **FP risk reduced to `low`; standard clean corpus applies.** A single optional clean neighbor documenting the obscure fish sense is sufficient if encountered during PR 3 corpus authoring — not a mandatory expanded biology lane.

#### A09 — `kahpe`

- **Category / severity:** insult / medium
- **Rationale:** Character betrayal insult; stable standalone token; low collision.
- **Minimum corpus:** 3 clean (+1 historical-literary), 3 profane, 3 obfuscated
- **Normalization:** Key `kahpe` unique

#### A10 — `kaltak`

- **Category / severity:** sexual / medium
- **Rationale:** terlik.js sexual tier; stable standalone token.
- **Minimum corpus:** 3 clean, 3 profane, 3 obfuscated
- **Normalization:** Key `kaltak` unique

#### A11 — `sürtük`

- **Category / severity:** sexual / medium
- **Rationale:** Common sexual insult in live chat; low lexical FP per Agent 3.
- **Minimum corpus:** 3 clean, 3 profane, 3 obfuscated
- **Normalization:** Author `sürtük` → key `surtuk`; ASCII fold in obfuscated corpus

#### A12 — `yarrak`

- **Category / severity:** sexual / high
- **Rationale:** Dominant sexual slang in FPS trash talk and social comments; prefer over `yarak`.
- **Minimum corpus:** 3 clean, 3 profane, 3 obfuscated (+2 `yarak` as positive obfuscation)
- **Normalization:** Do not add `yarak`/`yrk`/`yrrk` rows; document gaps

#### A13 — `amcık`

- **Category / severity:** sexual / high
- **Rationale:** discord-filter default; high gaming frequency; distinct from seed family.
- **Minimum corpus:** 3 clean (+2 fold neighbors), 3 profane, 3 obfuscated
- **Normalization:** Author `amcık` → key `amcik`; `amcıq` → `amciq` not covered

#### A14 — `fahişe`

- **Category / severity:** sexual / medium
- **Rationale:** Agent 3 optional slot; valid sexual slang with manageable historical-descriptive FP.
- **Minimum corpus:** 3 clean (+2 historical-descriptive), 3 profane, 3 obfuscated
- **Normalization:** Author `fahişe` → key `fahise`

#### A15 — `sktr`

- **Category / severity:** abbreviation / medium
- **Rationale:** Primary gaming abbreviation for `siktir`; Agent 4 requires separate row; fills abbreviation slot.
- **Minimum corpus:** 6 clean (+3 innocent gaming/acronym), 3 profane, 3 obfuscated
- **Normalization:** Key `sktr` ≠ `siktir`; spelled-chain `s.k.t.r` converges; first abbreviation proof gate

---

## PR 3 — Maintainer implementation note

PR 3 is delivered as **one feature branch and one merged pull request**. Do not split Batch 1 across multiple GitHub PRs.

Implementation should proceed in **two internal phases** on that single branch:

| Phase | Scope | Exit criteria |
|-------|--------|---------------|
| **Phase 1** | Implement approximately half of the 15 approved entries (dictionary rows + corpus fixtures) | Corpus quality verified for implemented entries; full test suite passes |
| **Phase 2** | Implement the remaining approved entries | Aggregate FP/FN/coverage gates pass; Batch 1 complete |

Suggested Phase 1 split (7 entries — insult + sexual core, lowest FP complexity):

`gerizekalı`, `dangalak`, `pezevenk`, `salak`, `kahpe`, `kaltak`, `sürtük`

Suggested Phase 2 split (8 entries — remaining insults, sexual, abbreviation proof gate):

`şerefsiz`, `gavat`, `dalyarak`, `andaval`, `yarrak`, `amcık`, `fahişe`, `sktr`

Phase boundaries are a **workflow convenience** for the implementer — not separate review units. All 15 entries land in one PR with one risk assessment block per entry.

---

## Deferred Candidates

Candidates classified as **Deferred** in Stage 2. Copied here for tracking and future reconsideration.

| Candidate ID | Candidate term | Reason for deferral | Reconsideration condition |
|--------------|----------------|---------------------|---------------------------|
| C02 | aptal | Meta-linguistic/educational standalone FP; Agent 3 binding defer | Expanded meta-linguistic clean lane; FP = 0 proven |
| C05 | yavşak | Zoological homonym (fish); Agent 3 binding defer | Biology/fishing clean corpus (+4 frames) |
| C11 | piç | Normalized key `pic` collides with English `pic`; Agent 3 binding defer | Mixed-language TR+EN corpus lane |
| C16 | yarak | Duplicate intent with C15 `yarrak`; different key | Only if `yarrak` corpus insufficient for recall |
| C18 | göt | English `got` collision; 3-char; `6öt` leet gap | Mixed-language corpus + pipeline `6`→`ö` evaluation |
| C19 | puşt | Borderline slur-adjacent; ethics defer | Post-v0.4 slur-adjacent policy |
| C20 | kaşar | Cheese homograph `kasar`; intent ambiguity | Food-domain clean corpus (+6 frames) |
| C23 | siktirgit | Compound overlap with seed `siktir` | Matcher compound policy clarified |
| C24 | lan | Ubiquitous particle standalone; 3-char FP | Standalone particle policy + 8+ clean frames |
| C25 | sokarım | Innocent `sokmak` conjugation homonym | Phrase-aware matching |
| C26 | ananı | Phrasal maternal insult fragment | Phrase-aware matching roadmap |
| C27 | aminakoyayim | Phrase-level token shape | Multi-token expression support |
| C29 | hassiktir | Elongation of seed `siktir` | Obfuscation corpus-only unless separate row justified |
| C32 | hsktir | Abbreviation class; depends on A15 precedent | After `sktr` passes one release cycle |
| C33 | amq | 3-char; redundant with seed `amk`/`aq` | Abbreviation policy exception |
| C34 | gerzek | Truncation duplicate of C03 | Only if long form insufficient for chat recall |

---

## Rejected Candidates

Candidates classified as **Rejected** in Stage 2. Copied here for audit trail.

| Candidate ID | Candidate term | Reason for rejection |
|--------------|----------------|----------------------|
| C22 | sokayım | Innocent `sokmak` conjugation homonym — FP gate unreachable (Agent 3 X01) |
| C28 | soktugum | Broad morphological family; low standalone precision |
| C30 | ibne | Slur-domain; v0.4 policy exclusion |
| C35 | pic | ASCII duplicate of `piç`; English `pic` collision |
| C36 | amcığa | Agglutinative fragment; unstable standalone shape |
| C37 | sikik | Root overlap with seed `siktir`; suffix matching not in v0.4 |
| C38 | götlalesi | Niche compound meme insult |
| C39 | godoş | Dated register in younger cohorts |
| C40 | kezban | Stereotype insult; given-name collision edge |
| C41 | oç / mk / sg | ≤2 characters; Batch 1 automatic reject |

**Seed entries not re-proposed:** `amk`, `aq`, `siktir`, `orospu`, `mal` — already in [`data/tr.php`](../data/tr.php).

---

## PR3 Readiness Checklist

PR 3 cannot start until all items below are satisfied:

- [x] Candidate pool contains approximately 30–40 entries (40 unique candidates in Stage 1)
- [x] Every candidate classified (Recommended / Deferred / Rejected)
- [x] Exactly 15 approved entries in Stage 3
- [x] No slur entries
- [x] No new ≤2 character entries
- [x] Every approved entry has a corpus plan
- [x] FP risk documented for every approved entry
- [x] Normalized collision risk checked against existing dictionary and other candidates
- [x] Maintainer approval recorded

---

## Related documents

| Document | Purpose |
|----------|---------|
| [`docs/dictionary-expansion-policy.md`](dictionary-expansion-policy.md) | Taxonomy, Batch 1 rules, corpus requirements |
| [`docs/research/agent-1-gaming-chat.md`](research/agent-1-gaming-chat.md) | Gaming & live-chat research |
| [`docs/research/agent-2-general-internet.md`](research/agent-2-general-internet.md) | General internet research |
| [`docs/research/agent-3-fp-review.md`](research/agent-3-fp-review.md) | False-positive quality review |
| [`docs/research/agent-4-normalization.md`](research/agent-4-normalization.md) | Normalization variant research |
| [`docs/specification.md`](specification.md) | Dictionary author format |
| [`CONTRIBUTING.md`](../CONTRIBUTING.md) | Three-PR expansion workflow |
| [`tests/Fixtures/tr/README.md`](../tests/Fixtures/tr/README.md) | Corpus fixture format |
