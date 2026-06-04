const CACHE_NAME = 'sim-iklim-v1';
const STATIC_ASSETS = [
    '/offline',
];

// ---------------------------------------------------------------------------
// Install — precache the offline fallback page
// ---------------------------------------------------------------------------

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => cache.addAll(STATIC_ASSETS))
    );
    self.skipWaiting();
});

// ---------------------------------------------------------------------------
// Activate — claim all clients and purge old caches
// ---------------------------------------------------------------------------

self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) =>
            Promise.all(
                cacheNames
                    .filter((name) => name !== CACHE_NAME)
                    .map((name) => caches.delete(name))
            )
        )
    );
    self.clients.claim();
});

// ---------------------------------------------------------------------------
// Fetch — Network First for HTML navigation, Cache First for static assets
// ---------------------------------------------------------------------------

self.addEventListener('fetch', (event) => {
    const { request } = event;
    const url = new URL(request.url);

    // Only intercept same-origin requests
    if (url.origin !== self.location.origin) {
        return;
    }

    const isNavigation = request.mode === 'navigate';
    const isStaticAsset = /\.(css|js|woff2?|png|jpg|jpeg|svg|webp|ico)$/.test(url.pathname);

    if (isNavigation) {
        // Network First: serve latest HTML, fall back to offline page on failure
        event.respondWith(
            fetch(request)
                .then((response) => {
                    const clone = response.clone();
                    caches.open(CACHE_NAME).then((cache) => cache.put(request, clone));
                    return response;
                })
                .catch(() =>
                    caches.match(request).then(
                        (cached) => cached || caches.match('/offline')
                    )
                )
        );
        return;
    }

    if (isStaticAsset) {
        // Cache First: static assets are content-hashed by Vite, safe to cache aggressively
        event.respondWith(
            caches.match(request).then(
                (cached) =>
                    cached ||
                    fetch(request).then((response) => {
                        const clone = response.clone();
                        caches.open(CACHE_NAME).then((cache) => cache.put(request, clone));
                        return response;
                    })
            )
        );
    }
});

// ---------------------------------------------------------------------------
// Push — handle Web Push notifications from server
// ---------------------------------------------------------------------------

self.addEventListener('push', (event) => {
    const data = event.data ? event.data.json() : {};
    const title = data.title || 'SIM Iklim BMKG';
    const options = {
        body: data.body || 'Ada informasi iklim terbaru.',
        icon: '/icons/icon-192x192.png',
        badge: '/icons/icon-192x192.png',
        data: data.url ? { url: data.url } : {},
    };

    event.waitUntil(self.registration.showNotification(title, options));
});

// ---------------------------------------------------------------------------
// Notification click — open the associated URL
// ---------------------------------------------------------------------------

self.addEventListener('notificationclick', (event) => {
    event.notification.close();

    if (event.notification.data && event.notification.data.url) {
        event.waitUntil(clients.openWindow(event.notification.data.url));
    }
});
