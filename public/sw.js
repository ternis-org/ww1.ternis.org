/**
 * Service Worker for ternis.org
 * Provides offline caching and fast asset loading
 */

const CACHE_NAME = 'ternis-org-v1';
const ASSETS_TO_CACHE = [
    '/',
    '/en',
    '/de',
    '/assets/css/app.css',
    '/assets/js/app.js',
    '/favicon.ico',
    '/robots.txt'
];

self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME).then(cache => {
            return cache.addAll(ASSETS_TO_CACHE).catch(() => {});
        }).then(() => self.skipWaiting())
    );
});

self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(keys => {
            return Promise.all(
                keys.filter(key => key !== CACHE_NAME).map(key => caches.delete(key))
            );
        }).then(() => self.clients.claim())
    );
});

self.addEventListener('fetch', event => {
    // Only handle GET requests
    if (event.request.method !== 'GET') return;

    // Do not cache API routes
    if (event.request.url.includes('/api/')) return;

    event.respondWith(
        caches.match(event.request).then(cachedResponse => {
            if (cachedResponse) {
                // Fetch fresh copy in background (stale-while-revalidate)
                fetch(event.request).then(networkResponse => {
                    if (networkResponse && networkResponse.status === 200) {
                        caches.open(CACHE_NAME).then(cache => {
                            cache.put(event.request, networkResponse.clone());
                        });
                    }
                }).catch(() => {});
                return cachedResponse;
            }

            return fetch(event.request).then(networkResponse => {
                if (networkResponse && networkResponse.status === 200 && event.request.url.startsWith(self.location.origin)) {
                    const responseClone = networkResponse.clone();
                    caches.open(CACHE_NAME).then(cache => {
                        cache.put(event.request, responseClone);
                    });
                }
                return networkResponse;
            }).catch(() => {
                // Fallback if offline
                return caches.match('/en') || caches.match('/');
            });
        })
    );
});
