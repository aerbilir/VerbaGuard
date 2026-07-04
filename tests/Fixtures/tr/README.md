# Turkish Quality Corpus

Test-only fixture corpus for measuring Turkish dictionary quality against the dictionary in `data/tr.php`.

## Files

| File | Purpose | Expected detection |
|------|---------|-------------------|
| `clean.php` | Innocuous text; false-positive candidates | `false` |
| `profane.php` | Direct profanity and insult detection | `true` |
| `obfuscated.php` | Leetspeak, separators, folding, repeats | `true` |
| `edge_cases.php` | Boundary behavior (mixed expectations) | per case |

## Case format

```php
[
    'id' => 'clean.malzeme.embedded',
    'text' => 'malzeme listesi hazır',
    'expect' => [
        'detected' => false,
    ],
    'tags' => ['substring', 'mal-risk'],
    'note' => 'mal must not match inside malzeme',
]
```

### Required fields

- `id` — stable identifier (`category.slug`)
- `text` — UTF-8 input
- `expect.detected` — boolean

### Optional fields

- `expect.terms` — expected canonical dictionary terms present in `data/tr.php`
- `expect.match_count` — expected number of matches
- `expect.severity` — expected highest severity
- `expect.categories` — expected match categories
- `tags` — filtering labels
- `note` — human-readable rationale
- `risk` — dictionary expansion risk hint (`low`, `medium`, `high`)

## Rules

- Empty `text` is allowed **only** in `edge_cases.php`.
- `expect.terms` must reference terms present in `data/tr.php`.
- IDs must be unique across all fixture files.

## Quality gate

`TurkishCorpusQualityTest` enforces:

- false positives = 0
- false negatives = 0
- detection coverage = 100% (profane + obfuscated corpus)

See [docs/dictionary-expansion-policy.md](../../docs/dictionary-expansion-policy.md) before adding dictionary entries.
