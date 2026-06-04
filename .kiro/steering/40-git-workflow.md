---
inclusion: manual
---

# Git Workflow

## Branch Naming
- Feature: `feature/feature-name`
- Bugfix: `fix/bug-description`
- Hotfix: `hotfix/description`
- Release: `release/v1.x.x`

## Commit Messages (Conventional Commits)
- `feat: description of new feature`
- `fix: description of bug fix`
- `refactor: description of refactoring`
- `docs: documentation changes`
- `test: add or update tests`
- `chore: maintenance task`
- `style: formatting, missing semi colons, etc`
- `perf: performance improvement`

## Rules
- Commit messages: 100% English, no emojis
- Branching: create branch from `main` (or `develop` if exists)
- Before commit: code MUST pass `php artisan test` and `npm run build`
- Before committing PHP: run `vendor/bin/pint --dirty --format agent`
- Each commit should be atomic — one concern per commit
- Squash merge for feature branches
