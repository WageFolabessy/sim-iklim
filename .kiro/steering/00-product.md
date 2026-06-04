---
inclusion: always
---

# Product Context

## About
- Name: SIM Iklim BMKG — Climate Information System for West Kalimantan
- Description: A two-way climate information system for BMKG Climatology Station, West Kalimantan. Observers (PMG staff) input daily climate data, admins validate and publish it, and the public (farmers, fishers, citizens) receives real-time updates. Citizens can also submit weather anomaly reports back to BMKG.
- Target users: General public of West Kalimantan (visitors), PMG staff (observers), senior BMKG staff (admins)
- Domain: Climate information system / BMKG weather monitoring

## Core Features
- Public: current climate data, historical statistics (AVG/MIN/MAX/STDDEV), citizen weather reports
- Observer: daily climate data input, own input history
- Admin: data validation & publication, full CRUD, extreme weather alert trigger, citizen report moderation
- System: scheduled statistics calculation, service worker data caching, push notifications
- Realtime: Reverb broadcasts new data & alerts to online visitors
- PWA: offline access, install to home screen, push notification via minishlink/web-push

## Constraints
- Database: MySQL only (session, cache, queue all use database driver)
- Authentication: Laravel Auth native with enum `role` column (NOT Spatie Permission, NOT Fortify)
- Roles: 2 roles only — `admin` and `pengamat` (visitor = unauthenticated public, no role)
- Frontend: Blade + Tailwind CSS v4 (NOT Inertia, NOT React, NOT shadcn/ui)
- Realtime: Laravel Reverb + Laravel Echo
- Push notification: laravel-notification-channels/webpush (wraps minishlink/web-push)
- PWA: Service Worker + Cache API + Web App Manifest
- Locale: `id` (Bahasa Indonesia), timezone: `Asia/Pontianak` (West Kalimantan)
- All UI text must be in Bahasa Indonesia
- All code (variables, classes, methods, commits) must be in English
- HTTPS required in production (Service Worker + Push requirement)
