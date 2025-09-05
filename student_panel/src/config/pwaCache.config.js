export const CACHE_CONFIG = [
    {
        // Cache HTML files with a Network First strategy
        urlPattern: ({ request }) => request.destination === 'document',
        handler: 'NetworkFirst',
        options: {
            cacheName: 'html-cache',
            expiration: {
                maxEntries: 10,
                maxAgeSeconds: 60 * 60 * 24, // 1 day
            },
        },
    },
    {
        // Cache CSS and JS files with a Stale While Revalidate strategy
        urlPattern: ({ request }) =>
            request.destination === 'style',
        handler: 'StaleWhileRevalidate',
        options: {
            cacheName: 'assets-cache',
            expiration: {
                maxEntries: 50,
                maxAgeSeconds: 60 * 60 * 24 * 30, // 30 days
            },
        },
    },
    {
        // Cache fonts with a Cache First strategy
        urlPattern: ({ request }) => request.destination === 'font',
        handler: 'CacheFirst',
        options: {
            cacheName: 'font-cache',
            expiration: {
                maxEntries: 30, // Cache up to 30 font files
                maxAgeSeconds: 60 * 60 * 24 * 365, // Cache for 1 year
            },
            cacheableResponse: {
                statuses: [0, 200], // Cache successful and opaque font requests
            },
        },
    },
    {
        // Cache images with Cache First strategy
        urlPattern: ({ request }) => request.destination === 'image',
        handler: 'CacheFirst',
        options: {
            cacheName: 'image-cache',
            expiration: {
                maxEntries: 100,
                maxAgeSeconds: 60 * 60 * 24 * 365, // 1 year
            },
        },
    },
    {
        // Cache API responses with a Network First strategy
        urlPattern: /\/api\/.*$/,
        handler: 'NetworkFirst',
        options: {
            cacheName: 'api-cache',
            expiration: {
                maxEntries: 50,
                maxAgeSeconds: 60 * 60 * 24, // 1 day
            },
            cacheableResponse: {
                statuses: [200] // Only cache successful responses
            },
            networkTimeoutSeconds: 10 // Wait 5 seconds for a network response, then fallback to cache
        },
    },
    {
        urlPattern: ({ request }) => request.destination === 'script',
        handler: 'StaleWhileRevalidate',
        options: {
            cacheName: 'js-cache',
            expiration: {
                maxEntries: 50, // Cache up to 50 JS files
                maxAgeSeconds: 60 * 60 * 24 * 30, // Cache for 30 days
            },
        },
    }
]