const CACHE_NAME = 'pwa-fdg-v1';
const urlsToCache = [
    '/assets/js/paliLookup.js',
    '/assets/js/autopali.js',
    '/assets/js/textinfo.js',
    '/assets/js/linksbw.js',
    '/assets/js/linksdpr.js',
    '/assets/js/linksru.js',
    '/ru/index.php',
    '/read.php',
    '/ru/read.php',
    '/index.php',
    '/assets/img/icon-192x192.png',
    '/assets/img/icon-512x512.png',
    '/read/index.html',
    '/r/index.html',
    '/',
    '/r/',
    '/ru/',
    '/read/',
    '/pm.php',
    '/bipm.php',
    '/assets/texts/sutta_words.txt'
];

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then((cache) => {
                return cache.addAll(urlsToCache);
            })
    );
});

self.addEventListener('fetch', (event) => {
    event.respondWith(
        caches.match(event.request)
            .then((response) => {
                return response || fetch(event.request);
            })
    );
});