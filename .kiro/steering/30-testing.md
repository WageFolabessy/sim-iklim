---
inclusion: fileMatch
fileMatch: tests/**/*
---

# Testing Standards

## Framework
- Pest v4 with `LazilyRefreshDatabase` (configured in `tests/Pest.php`)
- CSRF middleware is globally disabled in tests (PreventRequestForgery)

## Creating Tests
- Command: `php artisan make:test --pest {name}` (Feature test)
- Command: `php artisan make:test --pest --unit {name}` (Unit test)
- Do NOT prefix with `Feature/` or `Unit/` — Artisan places them automatically
- Most tests should be Feature tests
- When creating models for tests, use factories — check factory custom states first

## Running Tests
- All: `php artisan test --compact`
- Filter: `php artisan test --compact --filter=testName`
- File: `php artisan test --compact tests/Feature/ExampleTest.php`
- Do not create verification scripts or tinker when tests cover that functionality

## Naming Conventions
- Check sibling files — follow existing `test()` or `it()` pattern
- Test descriptions should clearly describe the behavior being tested

## Directory Structure
- `tests/Feature/Auth/` — Login/logout tests
- `tests/Feature/Admin/` — Admin panel tests (CRUD, validation, moderation)
- `tests/Feature/Pengamat/` — Observer input/history tests
- `tests/Feature/Public/` — Public page tests (home, data, citizen reports)
- `tests/Unit/` — Unit tests for commands, services, helpers

## Assertions
- `assertSuccessful()` — NOT `assertStatus(200)`
- `assertNotFound()` — NOT `assertStatus(404)`
- `assertForbidden()` — NOT `assertStatus(403)`
- `assertModelExists()` — NOT raw `assertDatabaseHas()`
- `assertRedirect()` for redirect responses

## Factory & Data Setup
- MUST use factory states — avoid manual overrides
- Check factory custom states before manual setup
- `recycle()` to share relationship instances across factories
- Fakes (`Event::fake()`, `Exceptions::fake()`) MUST be placed AFTER factory setup, not before
- Faker: follow existing convention (`$this->faker` or `fake()`)

## Required Test Coverage
Every feature/CRUD/business logic MUST have tests covering:
- Happy path (normal flow)
- Access control (unauthenticated redirect, wrong role gets 403)
- Validation errors (invalid input gets 422)
- Database state assertions (records created/updated/deleted)
- Edge cases (empty, null, boundary values)

## Mocking
- Import: `use function Pest\Laravel\mock;`
- `Http::fake()` and `preventStrayRequests()` for HTTP client tests
- `Event::fake()` for broadcast event tests
- `Notification::fake()` for push notification tests

## Rules
- NEVER delete tests without approval
- Every code change must be tested programmatically
- Run minimum tests needed to ensure quality
- All tests MUST pass before finalizing changes
