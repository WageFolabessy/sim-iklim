---
inclusion: fileMatch
fileMatch: resources/views/**/*
---

# Blade & Reverb Conventions

## Blade Templates

### Layout System
- Base layout: `resources/views/layouts/app.blade.php` — shared nav, footer, meta tags, SW register
- Guest layout: `resources/views/layouts/guest.blade.php` — public-facing pages
- Use `@extends('layouts.app')` and `@section('content')` pattern
- OR use Blade component approach: `<x-app-layout>` / `<x-guest-layout>`

### Components
- Location: `resources/views/components/`
- Organize by responsibility: `components/ui/` (buttons, inputs), `components/` (domain-specific)
- Props via `@props(['title', 'value'])` directive
- `{{ $slot }}` for default slot content
- `{{ $attributes->merge(['class' => 'default-classes']) }}` for HTML attribute forwarding
- `@class()` directive for conditional class application

### Forms
- `@csrf` on ALL POST/PUT/DELETE forms — no exceptions
- `@method('PUT')` / `@method('DELETE')` for non-POST HTTP methods
- Error display: `@error('field') <span>{{ $message }}</span> @enderror`
- Old input preservation: `old('field', $default)`
- Form action: use `route('name')` helper — NEVER hardcode URLs
- Data to JS: use `data-*` attributes or `@json()` — never template literal interpolation

### Data Display
- `{{ }}` for escaped output (default — use for ALL user-generated content)
- `{!! !!}` ONLY for trusted HTML (admin-authored, pre-sanitized content)
- `@forelse` / `@empty` for lists with empty state handling
- Pagination: `{{ $records->links() }}`
- Default sort: always use `->latest()` — never leave ordering undefined

### Conditional Rendering
- `@auth` / `@guest` for authentication-based content visibility
- `@can` / `@cannot` for policy-based authorization checks in UI
- Custom Blade directives or inline checks for role-based UI (`auth()->user()->role`)

## Laravel Echo & Reverb (Realtime)

### Public Channel Subscription (in Blade)
```html
@push('scripts')
<script>
    window.Echo.channel('climate-data')
        .listen('ClimateDataPublished', (event) => {
            // Update DOM with event data
        });
</script>
@endpush
```

### Event Classes
- Implement `ShouldBroadcast` (queued) — NOT `ShouldBroadcastNow` (blocks request)
- Public channels: return `new Channel('channel-name')` from `broadcastOn()`
- Define `broadcastWith()` to control payload shape and minimize data transfer
- Define `broadcastAs()` for custom event name if needed
- Use `ShouldDispatchAfterCommit` when dispatching inside database transactions

### Channel Types for This Project
All channels are PUBLIC (visitors are unauthenticated):
- `climate-data` — newly published climate records
- `weather-alerts` — admin-triggered extreme weather warnings
- `citizen-reports` — newly submitted citizen weather reports

### Broadcasting from Controller
```php
// Option 1: Dispatch event (recommended — auto-queued)
ClimateDataPublished::dispatch($climateRecord);

// Option 2: Broadcast helper (exclude sender)
broadcast(new WeatherAlertBroadcasted($alert))->toOthers();
```

## Service Worker

### Registration (in base layout)
```html
<script>
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/sw.js')
            .then(reg => console.log('SW registered'))
            .catch(err => console.error('SW failed:', err));
    }
</script>
```

### Cache Strategy
- Static assets (CSS, JS, fonts, images): Cache First — fastest for immutable resources
- HTML pages: Network First — ensures users see latest content
- API/data responses: Network First with cache fallback for offline access
- Precache critical assets on `install` event
- Clean old caches on `activate` event
- Avoid Cache First for HTML — prevents users from seeing updates

### Push Notification Flow
1. Client: request notification permission via `Notification.requestPermission()`
2. Client: subscribe via `PushManager.subscribe()` with VAPID public key
3. Client: send subscription to server (`POST /push-subscriptions`)
4. Server: store via laravel-notification-channels/webpush `HasPushSubscriptions` trait
5. Admin triggers alert -> server sends push via `WebPushChannel`
6. Service Worker: handle `push` event, call `self.registration.showNotification()`

### Offline Fallback
- Create a dedicated `/offline` route serving a branded offline page
- Service Worker intercepts failed navigation requests and serves offline page
- This provides a better UX than the browser's default error page

## Common Pitfalls
- Missing `@csrf` on forms (CSRF vulnerability)
- Using `{!! !!}` for user-generated content (XSS vulnerability)
- Hardcoding URLs instead of `route('name')` (breaks when routes change)
- Missing `@error` blocks for form validation feedback
- Not using `old()` for form field repopulation after validation failure
- Complex PHP logic in Blade — move to controller or View Composer
- Forgetting to register Service Worker in base layout
- Using `ShouldBroadcastNow` instead of `ShouldBroadcast` (blocks HTTP response)
- Not cleaning old Service Worker caches (stale assets)
- Caching HTML with Cache First strategy (users never see updates)
