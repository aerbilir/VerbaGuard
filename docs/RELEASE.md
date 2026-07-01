# Release Strategy

This document describes versioning, tagging, and publishing for VerbaGuard.

## Versioning

VerbaGuard follows [Semantic Versioning](https://semver.org/):

| Bump | When |
|------|------|
| **MAJOR** | Breaking public API changes |
| **MINOR** | Backward-compatible features |
| **PATCH** | Backward-compatible bug fixes |

Pre-1.0 releases (`0.x.y`) may include breaking changes with MINOR bumps as documented in `CHANGELOG.md`.

## Release Checklist

Before tagging a release:

1. All CI checks pass on `main`
2. `CHANGELOG.md` has a dated section for the version
3. `README.md` and `docs/specification.md` match implementation
4. No known critical correctness bugs
5. Tag matches `composer.json` version (when added)

## Creating a Release

```bash
# Ensure clean main
git checkout main
git pull

# Update CHANGELOG.md — move [Unreleased] items to [X.Y.Z] - YYYY-MM-DD

# Tag
git tag -a v0.1.0 -m "v0.1.0 — initial public release"
git push origin v0.1.0
```

Then on GitHub:

1. **Releases → Draft a new release** from the tag
2. Copy the `CHANGELOG.md` section as release notes
3. Publish

## Packagist (future)

When ready for Packagist:

1. Make the GitHub repository public
2. Submit `verbaguard/verbaguard` to [Packagist](https://packagist.org/)
3. Enable GitHub webhook for auto-update on tag push

## Post-Public Repository Setup

After making the repository public, complete these manual steps in GitHub Settings:

1. **Enable Discussions** (optional) — Settings → General → Features → Discussions. If enabled, you may add a Discussions contact link to `.github/ISSUE_TEMPLATE/config.yml`.
2. **Import labels** — see [Labels](#labels) below.
3. **Add topics** — see [GitHub Topics](#github-topics) below.

## GitHub Topics

After making the repository public, add these topics in repository settings:

```
php
moderation
profanity-filter
text-moderation
turkish
language-aware
content-moderation
composer-package
```

## Branch Policy

- `main` — stable, release-ready code
- Feature branches — short-lived, merged via pull request
- Tags — immutable release markers (`v0.1.0`, `v0.1.1`, …)

## Support Policy

| Version | Support |
|---------|---------|
| Latest `0.x` | Bug fixes and security patches |
| Older `0.x` | Best effort |

See [SECURITY.md](../SECURITY.md) for vulnerability reporting.

## Labels

Issue labels are defined in [`.github/labels.yml`](../.github/labels.yml). Import with:

```bash
gh label import .github/labels.yml --force
```

(Requires [GitHub CLI](https://cli.github.com/) and repository admin access.)
