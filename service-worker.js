const cacheName = "tienda-online-v1";

// Lista de recursos a almacenar en caché
const resourcesToCache = [
    "/TiendaOnline/",
    "/TiendaOnline/Login.html",
    "/TiendaOnline/manifest.json",
    "/TiendaOnline/Logo Zephyr 192x111.png",
    "/TiendaOnline/Logo Zephyr 512x297.png"
];

// Instalar el service worker
self.addEventListener("install", (event) => {
    event.waitUntil(
        caches.open(cacheName).then((cache) => {
            return cache.addAll(resourcesToCache);
        })
    );
});

// Activar el service worker
self.addEventListener("activate", (event) => {
    const cacheWhitelist = [cacheName];
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((cache) => {
                    if (cacheWhitelist.indexOf(cache) === -1) {
                        // Eliminar los cachés antiguos
                        return caches.delete(cache);
                    }
                })
            );
        })
    );
});

// Recuperar los archivos desde la caché cuando no haya red
self.addEventListener("fetch", (event) => {
    event.respondWith(
        caches.match(event.request).then((response) => {
            // Si el recurso ya está en caché, devolverlo
            return response || fetch(event.request);  // Si no está en caché, hacer la solicitud normalmente
        })
    );
});
