// Service Worker for Push Notifications

// VAPID public key (must match server configuration)
const VAPID_PUBLIC_KEY = 'BH713nXU9JhRgVkli85ccpcAKlNIkEMfJFz1vPtCTHR7DgaBObtDyYAgsK72nQteTcEA-zKRoBTVvpDC9Z9vsG0';

self.addEventListener('push', function(event) {
    console.log('Push received:', event.data ? event.data.text() : 'No data');

    let data = {
        title: 'InayaFleet360',
        body: 'You have a new notification',
        icon: '/admin_resource/assets/images/icons.png',
        badge: '/admin_resource/assets/images/icons.png',
        tag: 'inayafleet-notification',
        renotify: true,
        data: { url: '/admin/dashboard' }
    };

    if (event.data) {
        try {
            const jsonData = event.data.json();
            console.log('Push data:', jsonData);
            data.title = jsonData.title || data.title;
            data.body = jsonData.body || data.body;
            data.icon = jsonData.icon || data.icon;
            data.data = jsonData.data || { url: jsonData.url || '/admin/dashboard' };
        } catch (err) {
            console.log('Parse error, using text:', err);
            data.body = event.data.text() || data.body;
        }
    }

    // Show the notification
    event.waitUntil(
        self.registration.showNotification(data.title, {
            body: data.body,
            icon: data.icon,
            badge: data.badge,
            tag: data.tag,
            renotify: data.renotify,
            data: typeof data.data === 'object' ? (data.data.url || '/admin/dashboard') : data.data,
            vibrate: [200, 100, 200],
            requireInteraction: true,
            actions: [
                { action: 'open', title: 'Open' },
                { action: 'close', title: 'Close' }
            ]
        }).then(() => {
            console.log('Notification shown successfully');
        }).catch(err => {
            console.error('Notification error:', err);
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
