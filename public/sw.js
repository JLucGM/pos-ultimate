/**
 * Audaz POS - Progressive Web App Service Worker
 * Version: 1.0.1 - Fix: Never intercept HTML navigation requests to prevent stale CSRF tokens
 */

const CACHE_NAME = 'audaz-pos-v2';
const STATIC_ASSETS = [
    '/manifest.json',
    '/favicon.ico',
    '/img/icons/icon-192x192.png',
    '/img/icons/icon-512x512.png',
    '/img/logo-small.png',
    '/img/logo-audaz.png'
];

// Install Event - Pre-cache core static assets
self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.addAll(STATIC_ASSETS);
        }).then(() => self.skipWaiting())
    );
});

// Activate Event - Clean up stale caches & take control immediately
self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((cache) => {
                    if (cache !== CACHE_NAME) {
                        return caches.delete(cache);
                    }
                })
            );
        }).then(() => self.clients.claim())
    );
});

// Fetch Event - ONLY cache static assets (images, icons, fonts). NEVER intercept HTML/navigation requests!
self.addEventListener('fetch', (event) => {
    // Only handle GET requests
    if (event.request.method !== 'GET') {
        return;
    }

    // NEVER intercept HTML page navigation requests (login, dashboard, etc.) to ensure CSRF tokens and sessions are always fresh
    if (event.request.mode === 'navigate' || event.request.destination === 'document') {
        return;
    }

    const url = new URL(event.request.url);

    // Only cache static files (images, icons, fonts)
    if (
        url.pathname.startsWith('/img/') ||
        url.pathname.startsWith('/fonts/') ||
        url.pathname.endsWith('.png') ||
        url.pathname.endsWith('.jpg') ||
        url.pathname.endsWith('.jpeg') ||
        url.pathname.endsWith('.svg') ||
        url.pathname.endsWith('.woff2')
    ) {
        event.respondWith(
            caches.match(event.request).then((cachedResponse) => {
                if (cachedResponse) {
                    return cachedResponse;
                }
                return fetch(event.request).then((networkResponse) => {
                    if (networkResponse && networkResponse.status === 200) {
                        const responseClone = networkResponse.clone();
                        caches.open(CACHE_NAME).then((cache) => {
                            cache.put(event.request, responseClone);
                        });
                    }
                    return networkResponse;
                }).catch(() => {
                    return cachedResponse;
                });
            })
        );
    }
});
