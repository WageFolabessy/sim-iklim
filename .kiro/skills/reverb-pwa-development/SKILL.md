---
name: reverb-pwa-development
description: "Use this skill when implementing realtime features with Laravel Reverb, Laravel Echo, WebSocket broadcasting, Service Worker, PWA (Progressive Web App), offline cache, push notifications, or web-push. Covers: event broadcasting, channel authorization, Echo subscription in Blade, Service Worker lifecycle, Cache API strategies, Web App Manifest, VAPID keys, and laravel-notification-channels/webpush integration."
license: MIT
metadata:
  author: sim-iklim
---

# Reverb & PWA Development

## Documentation

Use `search-docs` for detailed Laravel Reverb and Broadcasting documentation.

## Laravel Reverb

### Creating Broadcast Events
```bash
php artisan make:event EventName --no-interaction
```

Event class must:
1. Implement `ShouldBroadcast` interface (queued — NOT `ShouldBroadcastNow`)
2. Define `broadcastOn()` returning channel(s)
3. Define public properties for broadcast payload
4. Optionally define `broadcastAs()` for custom event name
5. Optionally define `broadcastWith()` to minimize payload size
6. Use `ShouldDispatchAfterCommit` when dispatched inside database transactions

### Channel Types
- `Channel('name')` — public, no auth required (used for all channels in this project)
- `PrivateChannel('name')` — requires authentication
- `PresenceChannel('name')` — auth + presence tracking

### This Project's Channels
All channels are PUBLIC (visitors are unauthenticated):
- `climate-data` — newly published climate records
- `weather-alerts` — admin-triggered weather warnings
- `citizen-reports` — newly submitted citizen weather reports

### Echo Subscription in Blade
```html
@push('scripts')
<script>
    window.Echo.channel('channel-name')
        .listen('EventName', (event) => {
            // event contains broadcastWith() data
            // Update DOM accordingly
        });
</script>
@endpush
```

### Broadcasting from Controller
```php
// Option 1: Dispatch event (recommended — auto-queued via ShouldBroadcast)
ClimateDataPublished::dispatch($climateRecord);

// Option 2: Broadcast helper (exclude sender from receiving the event)
broadcast(new WeatherAlertBroadcasted($alert))->toOthers();
```

### Production Deployment
- Run Reverb behind a reverse proxy (Nginx or Caddy) for SSL termination
- Use `supervisor` or `systemd` to keep `php artisan reverb:start` running
- Restrict `allowed_origins` in `config/reverb.php` to production domain
- Consider Reverb database driver for horizontal scaling (new in Laravel 13)
- Monitor with Laravel Pulse for connection health

### Testing Broadcast Events
```php
Event::fake();

// Perform action that triggers broadcast
$this->post('/admin/data-iklim/1/validate');

// Assert event was dispatched
Event::assertDispatched(ClimateDataPublished::class);
```

## Progressive Web App (PWA)

### Web App Manifest (`public/manifest.json`)
Required fields:
- `name`, `short_name` — app display name
- `start_url` — entry point (typically `/`)
- `scope` — navigation scope (must match your domain)
- `display: standalone` — removes browser chrome
- `theme_color`, `background_color` — branding colors
- `icons`: 192x192 and 512x512 PNG (required for installability)

### Service Worker Lifecycle
1. `install` — precache critical static assets (CSS, JS, fonts)
2. `activate` — clean old versioned caches
3. `fetch` — intercept network requests and apply caching strategy

### Cache Strategies
- **Cache First**: static assets (CSS, JS, fonts, images) — fastest for immutable resources
- **Network First**: HTML pages, API data — ensures freshness, falls back to cache offline
- **Stale While Revalidate**: data that can be slightly outdated while refreshing in background

### IMPORTANT: Avoid These Cache Pitfalls
- NEVER use Cache First for HTML — prevents users from seeing updates and bug fixes
- Handle iOS Safari cache clearing (7 days inactivity) — design for graceful re-sync
- Implement SW update prompts so users reload when new version available

### Offline Fallback
- Create a dedicated `/offline` route with branded offline page
- Precache the offline page during SW `install` event
- Intercept failed navigation requests and serve offline page
- Better UX than browser's default error page

### Push Notification Flow
1. Client: request permission via `Notification.requestPermission()`
2. Client: subscribe via `PushManager.subscribe()` with VAPID public key from `.env`
3. Client: send subscription to server (`POST /push-subscriptions`)
4. Server: store subscription via `HasPushSubscriptions` trait (laravel-notification-channels/webpush)
5. Admin triggers weather alert -> Notification dispatched via `WebPushChannel`
6. Service Worker: handle `push` event, call `self.registration.showNotification()`
7. Service Worker: handle `notificationclick` to open relevant page

### Push Notification Setup
```bash
# Install package
composer require laravel-notification-channels/webpush

# Publish migrations and config
php artisan vendor:publish --provider="NotificationChannels\WebPush\WebPushServiceProvider" --tag="migrations"
php artisan migrate

# Generate VAPID keys (adds to .env automatically)
php artisan webpush:vapid
```

### Notification Class Example
```php
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class WeatherAlertNotification extends Notification
{
    public function via($notifiable): array
    {
        return [WebPushChannel::class];
    }

    public function toWebPush($notifiable, $notification): WebPushMessage
    {
        return (new WebPushMessage)
            ->title('Peringatan Cuaca')
            ->body($this->alert->pesan)
            ->action('Lihat Detail', route('home'));
    }
}
```

### Testing Push Notifications
```php
Notification::fake();

// Trigger alert
$this->post('/admin/peringatan/1/broadcast');

Notification::assertSentTo($subscriber, WeatherAlertNotification::class);
```

### HTTPS Requirement
- Service Workers and Push API require HTTPS in production
- Local development with `php artisan serve` works without HTTPS
- Use Let's Encrypt or Cloudflare for production SSL certificates

### Lighthouse Auditing
- Run Lighthouse audit in browser DevTools regularly
- Verify PWA installability, performance, accessibility scores
- Check service worker registration and offline capabilities

## Common Pitfalls
- Forgetting `ShouldBroadcast` interface on event class
- Using `ShouldBroadcastNow` instead of `ShouldBroadcast` (blocks HTTP response)
- Using private channels for public data (visitors cannot authenticate)
- Not handling `fetch` event in service worker (breaks offline)
- Not cleaning old caches in `activate` event (stale assets served)
- Forgetting to register service worker in base HTML layout
- VAPID keys not configured in `.env`
- Not handling expired push subscriptions (410 Gone responses)
- Missing `ShouldDispatchAfterCommit` when broadcasting inside transactions
- Cache First strategy on HTML pages (users never see updates)
