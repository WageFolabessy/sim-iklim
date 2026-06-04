---
name: tailwindcss-development
description: Activate when building responsive layouts, styling UI components, adding dark mode, fixing spacing or typography, or working with Tailwind CSS v4. Covers grid layouts, flex structures, cards, tables, navbars, forms, inputs, badges, and Tailwind v4 migration from v3. Activate when writing or fixing Tailwind utility classes in JSX or HTML templates.
---

# Tailwind CSS v4 Development

This skill provides patterns for Tailwind CSS v4 development in the Cangkir F&B Core project.

## Full Reference

#[[file:.agents/skills/tailwindcss-development/SKILL.md]]

## Project-Specific Rules

Key Tailwind v4 rules for this project:
- CSS-first config via `@theme` — NOT `tailwind.config.js`
- `@import "tailwindcss"` — NOT `@tailwind` directives
- `gap` utilities for spacing siblings — NOT margins
- Standard utility tokens — no arbitrary values unless branding
- Dark mode via `dark:` variant
- No deprecated v3 utilities
- UI components via shadcn/ui (Radix + CVA + Tailwind Merge)
