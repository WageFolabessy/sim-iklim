---
inclusion: always
---

# Architecture & Tech Stack

## Stack
- Language: PHP 8.4
- Backend: Laravel 13, Blade templating
- Frontend: Blade + Tailwind CSS v4 (CSS-first config via `@theme`, automatic content detection)
- Database: MySQL 8 (utf8mb4_unicode_ci)
- Cache/Session/Queue: Database driver
- Auth: Laravel Auth native + enum `role` column on users table
- Realtime: Laravel Reverb + Laravel Echo (pusher-js)
- Push notification: laravel-notification-channels/webpush (wraps minishlink/web-push)
- PWA: Service Worker + Cache API + Web App Manifest
- Build: Vite 8, Laravel Vite Plugin, @tailwindcss/vite
- Testing: Pest v4, Pint v1

## Application Structure

This project uses **standard Laravel directory structure** — NOT domain-driven design:

    app/
    ├── Console/Commands/    — Artisan commands (scheduled tasks)
    ├── Enums/               — PHP 8.1 backed enums (UserRole, ClimateRecordStatus, etc.)
    ├── Events/              — Broadcast events (Reverb)
    ├── Http/
    │   ├── Controllers/
    │   │   ├── Admin/       — Admin panel controllers
    │   │   ├── Auth/        — Login/logout controllers
    │   │   ├── Pengamat/    — Observer controllers (climate data input)
    │   │   └── Public/      — Public-facing controllers
    │   ├── Middleware/       — Custom middleware (role check)
    │   └── Requests/        — Form Request validation classes
    │       ├── Admin/
    │       ├── Auth/
    │       ├── Pengamat/
    │       └── Public/
    ├── Models/              — Eloquent models (User, ClimateRecord, etc.)
    ├── Notifications/       — Push notification classes (WebPush)
    ├── Policies/            — Authorization policies
    └── Providers/           — Service providers

### View Structure

    resources/views/
    ├── layouts/
    │   ├── app.blade.php        — Base layout (nav, footer, meta, SW register)
    │   └── guest.blade.php      — Public layout for unauthenticated users
    ├── auth/
    │   └── login.blade.php
    ├── admin/
    │   ├── dashboard.blade.php
    │   ├── climate-records/     — Full CRUD + validation
    │   ├── weather-alerts/      — CRUD + broadcast trigger
    │   └── citizen-reports/     — Moderation
    ├── pengamat/
    │   ├── dashboard.blade.php
    │   └── climate-records/     — Input + history
    ├── public/
    │   ├── home.blade.php       — Landing page with current data
    │   ├── climate-data/        — Historical data + statistics
    │   └── citizen-reports/     — Submit + browse reports
    └── components/              — Reusable Blade components (cards, alerts, etc.)

## Database Conventions
- Tables: snake_case, plural (users, climate_records, citizen_reports)
- Columns: snake_case (recorded_at, suhu_rata, curah_hujan)
- Foreign keys: `constrained()` method in migrations
- Indexes: defined in migration, not as afterthought — on WHERE, ORDER BY, JOIN columns
- One concern per migration — never mix DDL and DML
- Mirror column defaults in model `$attributes`
- Reversible `down()` by default

## Route Pattern
- Public routes: no auth middleware, named routes
- Auth routes: `auth` middleware with `throttle` on login
- Observer routes: `auth` + `role:pengamat` middleware, prefix `/pengamat`
- Admin routes: `auth` + `role:admin` middleware, prefix `/admin`
- Resource routes: `Route::resource()` where applicable
- Named routes: required for all routes — use `route()` helper, never hardcode URLs

## Auth & Role System
- 2 roles via `App\Enums\UserRole` backed enum: `Admin = 'admin'`, `Pengamat = 'pengamat'`
- Role stored as string column on `users` table, cast to `UserRole` enum
- Custom `EnsureUserHasRole` middleware for route protection
- Centralize authorization in Gates/Policies using enum comparison
- Public registration disabled — users created by admin only
- Password reset disabled — managed by admin
- Visitor = unauthenticated public, no role needed

## Broadcasting & Realtime
- Broadcast driver: Reverb (configured in .env)
- All channels are PUBLIC (visitors are unauthenticated):
  - `climate-data` — new published climate records
  - `weather-alerts` — admin-triggered weather warnings
  - `citizen-reports` — new citizen weather reports
- Echo configured in `resources/js/echo.js`
- Events implement `ShouldBroadcast` (queued, not `ShouldBroadcastNow`)
- Frontend listens via `window.Echo.channel()` in Blade `@push('scripts')` blocks
- CORS: restrict `allowed_origins` in `config/reverb.php` for production

## PWA Architecture
- `public/manifest.json` — Web App Manifest for installability (name, icons, display, scope)
- `public/sw.js` — Service Worker for offline cache + push notification handler
- Cache strategy: Network First for HTML/data, Cache First for static assets (CSS, JS, fonts)
- Dedicated offline fallback page (`/offline`) served when network unavailable
- Push subscription stored via laravel-notification-channels/webpush (auto-creates migration)
- VAPID keys generated via `php artisan webpush:vapid`
- Service Worker update strategy: prompt user to reload when new version available
- HTTPS required in production for Service Worker and Push API
