// Service Worker for Push Notifications

// VAPID public key (must match server configuration)
const VAPID_PUBLIC_KEY = 'BH713nXU9JhRgVkli85ccpcAKlNIkEMfJFz1vPtCTHR7DgaBObtDyYAgsK72nQteTcEA-zKRoBTVvpDC9Z9vsG0';

console.log('Service Worker loaded');

self.addEventListener('install', function(event) {
    console.log('Service Worker installing');
    self.skipWaiting();
});

self.addEventListener('activate', function(event) {
    console.log('Service Worker activating');
    event.waitUntil(clients.claim());
});

self.addEventListener('push', function(event) {
    console.log('Push event received!', event);
    console.log('Push data:', event.data ? event.data.json() : 'No data');

    let notificationData = {
        title: 'InayaFleet360',
        body: 'You have a new notification!',
        icon: '/admin_resource/assets/images/icons.png',
        badge: '/admin_resource/assets/images/icons.png',
        tag: 'inayafleet-notification',
        renotify: true,
        vibrate: [200, 100, 200],
        requireInteraction: true,
        data: '/admin/dashboard'
    };

    if (event.data) {
        try {
            const jsonData = event.data.json();
            console.log('JSON data:', jsonData);
            notificationData.title = jsonData.title || notificationData.title;
            notificationData.body = jsonData.body || notificationData.body;
            notificationData.icon = jsonData.icon || notificationData.icon;
            notificationData.data = jsonData.data?.url || jsonData.url || notificationData.data;
        } catch (e) {
            console.log('Not JSON, using text');
            notificationData.body = event.data.text() || notificationData.body;
        }
    }

    console.log('Showing notification:', notificationData);
    
    event.waitUntil(
        self.registration.showNotification(notificationData.title, {
            body: notificationData.body,
            icon: notificationData.icon,
            badge: notificationData.badge,
            tag: notificationData.tag,
            renotify: notificationData.renotify,
            data: notificationData.data,
            vibrate: notificationData.vibrate,
            requireInteraction: notificationData.requireInteraction
        }).then(() => {
            console.log('Notification shown!');
        }).catch(err => {
            console.error('Error showing notification:', err);
        })
    );
});

self.addEventListener('notificationclick', function(event) {
    event.notification.close();
    
    let clickUrl = '/';
    if (event.notification.data) {
        clickUrl = typeof event.notification.data === 'string' 
            ? event.notification.data 
            : (event.notification.data.url || '/');
    }
    
    event.waitUntil(
        clients.matchAll({ type: 'window', includeUncontrolled: true }).then(windowClients => {
            // Check if there's already a window open
            for (let client of windowClients) {
                if (client.url === clickUrl && 'focus' in client) {
                    return client.focus();
                }
            }
            // Open a new window
            if (clients.openWindow) {
                return clients.openWindow(clickUrl);
            }
        })
    );
});

// Handle service worker activation
self.addEventListener('activate', function(event) {
    event.waitUntil(
        clients.claim()
    );
});
