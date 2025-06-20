const CACHE_NAME = 'pwa-fdg-v1';
const urlsToCache = [
    '/ru/index.php',
    '/read.php',
    '/ru/read.php',
    '/index.php',
    '/assets/img/icon-192x192.png',
    '/assets/img/icon-512x512.png',
    '/read/index.html',
    '/r/index.html',
    '/pm.php',
    '/bipm.php',
    '/assets/texts/sutta_words.txt',
    '/assets/js/audioLazyLoad.js',
'/assets/js/autopali.js',
'/assets/js/bootstrap.bundle.5.3.1.min.js',
'/assets/js/copyToClipboard.js',
'/assets/js/jquery-3.7.0.min.js',
'/assets/js/jquery-ui.min.js',
'/assets/js/jquery-ui.js',
'/assets/js/linksbw.js',
'/assets/js/linksdpr.js',
'/assets/js/linksru.js',
'/assets/js/openDpr.js',
'/assets/js/loadCssJsMain.js',
'/assets/js/openBw.js',
'/assets/js/openFdg.js',
'/assets/js/openRu.js',
'/assets/js/opentexts.js',
'/assets/js/textinfo.js',
'/assets/js/paliLookup.js',
'/assets/js/pmjs.js',
'/assets/js/randPlaceholder.js',
'/assets/js/setDefaultMode.js',
'/assets/js/settings.js',
'/assets/js/smoothScroll.js',
'/assets/js/standalone-dpd/dpd_deconstructor.js',
'/assets/js/standalone-dpd/dpd_ebts.js',
'/assets/js/standalone-dpd/dpd_i2h.js',
'/assets/js/standalone-dpd/ru/dpd_ebts.js',
'/assets/js/switchView.js',
'/assets/js/themeswitch.js',
'/assets/js/tocjs.js',
'/assets/js/uihelp.js',
'/assets/js/variantsButton.js',
'/read/js/extra.js',
'/read/js/loadAssets.js',
'/read/js/urlForLbl.js'
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