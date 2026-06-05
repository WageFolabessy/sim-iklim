const CACHE_NAME = 'sim-iklim-v1';
const OFFLINE_URL = '/offline';

// Install Event: Cache the offline page
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => {
                return cache.add(OFFLINE_URL);
            })
            .then(() => {
                return self.skipWaiting();
            })
    );
});

// Activate Event: Clean up old caches and claim clients
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames.map(cacheName => {
                    if (cacheName !== CACHE_NAME) {
                        return caches.delete(cacheName);
                    }
                })
            );
        }).then(() => self.clients.claim())
    );
});

// Fetch Event: Network First, Cache Fallback strategy
self.addEventListener('fetch', event => {
    // Only intercept GET requests
    if (event.request.method !== 'GET') {
        return;
    }

    event.respondWith(
        fetch(event.request)
            .then(networkResponse => {
                // If successful, open cache and store a clone of the response
                return caches.open(CACHE_NAME).then(cache => {
                    // Only cache valid responses (status 200, or opaque responses which we can't reliably check)
                    // We also don't strictly need to check status if we just blindly cache successful requests,
                    // but it's a good practice.
                    cache.put(event.request, networkResponse.clone());
                    return networkResponse;
                });
            })
            .catch(() => {
                // If fetch fails (e.g. offline), try to match the request in cache
                return caches.match(event.request).then(cachedResponse => {
                    if (cachedResponse) {
                        return cachedResponse;
                    }
                    
                    // If not found in cache and it's a navigation request (HTML page), return the offline page
                    if (event.request.mode === 'navigate') {
                        return caches.match(OFFLINE_URL);
                    }

                    // Otherwise do nothing (could return a fallback image, etc.)
                });
            })
    );
});

// Push Event: Handle incoming push notifications
self.addEventListener('push', event => {
    if (!event.data) return;

    try {
        const data = event.data.json();
        event.waitUntil(
            self.registration.showNotification(data.title, {
                body: data.body,
                icon: data.icon,
                data: data.data
            })
        );
    } catch (e) {
        console.error('Error parsing push data', e);
    }
});

// Notification Click Event: Open the target URL
self.addEventListener('notificationclick', event => {
    event.notification.close();
    if (event.notification.data && event.notification.data.url) {
        event.waitUntil(
            clients.openWindow(event.notification.data.url)
        );
    }
});
