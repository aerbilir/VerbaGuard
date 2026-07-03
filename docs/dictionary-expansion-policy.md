# Turkish Dictionary Expansion Policy

This document defines the quality gate for adding or changing Turkish dictionary entries in VerbaGuard.

For corpus format and test infrastructure, see [`tests/Fixtures/tr/README.md`](../tests/Fixtures/tr/README.md).

---

## Principles

1. **False positives are worse than false negatives** — see [`FOUNDATION.md`](../FOUNDATION.md).
2. **Corpus before expansion** — measurable quality ground must exist before growing the dictionary.
3. **Short terms need extra care** — tokens of three characters or fewer have higher false-positive risk in real text.

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
