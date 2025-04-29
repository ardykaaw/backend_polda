const CACHE_NAME = 'absen-ditlantas-v1';
const urlsToCache = [
    '/',
    '/mobile/login',
    '/mobile/install',
    '/mobile/dashboard',
    '/mobile/profile',
    '/mobile/schedule',
    '/icons/icon-512x512.png',
    '/manifest.json',
    '/css/app.css',
    '/js/app.js'
];

// Install Service Worker
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => cache.addAll(urlsToCache))
    );
});

// Fetch Strategy
self.addEventListener('fetch', event => {
    event.respondWith(
        caches.match(event.request)
            .then(response => {
                // Return cached response if found
                if (response) {
                    return response;
                }
                // Clone the request because it can only be used once
                const fetchRequest = event.request.clone();
                // Make network request and cache the response
                return fetch(fetchRequest).then(response => {
                    // Check if valid response
                    if (!response || response.status !== 200 || response.type !== 'basic') {
                        return response;
                    }
                    // Clone the response because it can only be used once
                    const responseToCache = response.clone();
                    caches.open(CACHE_NAME)
                        .then(cache => {
                            cache.put(event.request, responseToCache);
                        });
                    return response;
                }).catch(() => {
                    // Fallback ke halaman login jika offline atau gagal fetch
                    return caches.match('/mobile/login');
                });
            })
    );
});

// Activate and clean up old caches
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames.filter(cacheName => {
                    return cacheName !== CACHE_NAME;
                }).map(cacheName => {
                    return caches.delete(cacheName);
                })
            );
        })
    );
});
