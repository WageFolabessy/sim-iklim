---
inclusion: always
---

# Coding Standards

## Language Boundary (STRICT)
- **Code** (variables, functions, classes, database columns, commit messages, inline comments): 100% English
- **UI text** (labels, buttons, navigation, toasts, flash messages): 100% Bahasa Indonesia
- **Backend error messages** (validation messages, exception messages): 100% Bahasa Indonesia
- **No emojis**: strictly prohibited in code, comments, UI text, and commit messages
- **Comments**: explain WHY (business logic / architectural decisions), never WHAT — code should be self-documenting

## PHP Standards

### Formatting & Structure
- PSR-12 base, enforced by Laravel Pint
- Curly braces required for all control structures, including single-line bodies
- Run `vendor/bin/pint --dirty --format agent` after modifying PHP files
- Use `php artisan make:` commands with `--no-interaction` to create new files
- If creating a generic PHP class, use `php artisan make:class`

### Type System
- PHP 8 constructor property promotion: `public function __construct(public GitHub $github) { }`
- Do not leave empty zero-parameter `__construct()` methods unless private
- Explicit return type declarations and type hints for all method parameters
- TitleCase for Enum keys: `Admin`, `Pengamat`, `Published`, `Banjir`
- Array shape type definitions in PHPDoc blocks
- PHPDoc blocks preferred over inline comments — only add inline for exceptionally complex logic

### Model Rules
- `$fillable` or `$guarded` required on every model (this project uses `#[Fillable]` attribute)
- Attribute casts in `casts()` method — not `$casts` property
- Local scopes for reusable query constraints
- `whereBelongsTo($model)` for cleaner queries
- `with()` for eager loading — prevent N+1 queries
- Enable `Model::preventLazyLoading()` in development
- Default sort: `->latest()` or `->latest('id')` — never leave ordering undefined
- Use Laravel helpers (`Str`, `Arr`, `Number`) over raw PHP functions

### Validation
- **Form Request classes ONLY** — inline `$request->validate()` is PROHIBITED
- `$request->validated()` only — NEVER use `$request->all()`
- Array notation `['required', 'email']`
- `Rule::when()` for conditional validation
- `after()` instead of `withValidator()`
- `messages()` and `attributes()` in Bahasa Indonesia

### Controller Rules
- Thin controllers: HTTP -> authorize -> validate (via Form Request) -> response
- Methods under 10 lines — extract to Action classes or Services if complex
- Business logic is PROHIBITED in controllers
- Type-hint Form Requests for auto-validation
- Implicit route model binding
- `Route::resource()` for CRUD routes
- Return `view()` or `redirect()` — this is a Blade project, NOT Inertia
- Every action must have authorization (Gate, Policy, or middleware)
- Use dependency injection, not `app()` or `resolve()`

### Security
- No raw SQL with user input — use Eloquent or Query Builder
- Parameter binding for `whereRaw()`, `selectRaw()`, `DB::raw()`
- `{{ }}` for output escaping in Blade — `{!! !!}` ONLY for trusted HTML
- `@csrf` on ALL POST/PUT/DELETE forms — no exceptions
- `throttle` middleware on login route
- File uploads: validate MIME type, extension, and size
- Store files with generated names, never user-provided filenames
- Secrets via `config()` only — never `env()` outside config files
- Run `composer audit` periodically for dependency vulnerabilities

### Blade Templates
- Blade components over `@include` — components have explicit props, not implicit variable sharing
- `$attributes->merge()` in component templates for class forwarding
- `@class()` directive for conditional styling
- `@pushOnce` for per-component scripts (prevents N duplicates in loops)
- `@aware` for deeply nested component props
- `route('name')` for all URLs — never hardcode paths
- `@error('field')` for validation error display
- `old('field', $default)` for form field repopulation
- `@forelse` / `@empty` for lists with empty state
- View Composers for shared view data (e.g., active alerts in navbar)
- Never put complex PHP logic in Blade — use controllers or View Composers
- No inline JS/CSS — pass data via data attributes or `@json()`
- Keep a consistent class ordering: layout → spacing → sizing → typography → visuals → interactive

### Styling (Tailwind CSS v4)
- CSS-first config via `@theme` directive — NOT `tailwind.config.js`
- `@import "tailwindcss"` — NOT `@tailwind` directives
- Automatic content detection — no need to configure content paths
- `gap` utilities for spacing siblings — NOT margins
- Standard Tailwind utility tokens — no arbitrary values unless branding
- Responsive design REQUIRED: `sm:`, `md:`, `lg:`, `xl:` breakpoints
- No deprecated v3 utilities (use `bg-black/*` not `bg-opacity-*`)
- Semantic HTML5: `<header>`, `<main>`, `<section>`, `<nav>`, `<aside>` — not generic `<div>`
- `cursor-pointer` and visual feedback (`hover:`, `focus:`) on all clickable elements
- `aria-labels` for icon-only buttons

### JavaScript (Vanilla + Echo)
- No TypeScript — this is a Blade project with vanilla JS
- Laravel Echo for WebSocket subscriptions
- DOM manipulation via vanilla JS or Alpine.js if needed
- Service Worker in `public/sw.js` — vanilla JS, no framework
- Data from PHP to JS via `data-*` attributes or `@json()` — never template literals

## Anti-Patterns (NEVER do these)
- Raw SQL with user input — use Eloquent or Query Builder
- `dd()` in commits
- Inline validation (`$request->validate()`) in controllers
- `$request->all()` — use `$request->validated()`
- `@tailwind` directives (v4 uses `@import`)
- Arbitrary Tailwind values without branding justification
- Business logic in controllers or Blade templates
- Margins for spacing siblings — use `gap`
- `env()` outside config files — use `config()`
- Complex PHP in Blade — use View Composers or pass data from controller
- `app()` / `resolve()` — use constructor injection
- `{!! !!}` for user-generated content (XSS vulnerability)
- Undefined query ordering — always use `latest()` or explicit `orderBy()`
- Missing `@csrf` on forms
- Hardcoded URLs — use `route('name')` helper
