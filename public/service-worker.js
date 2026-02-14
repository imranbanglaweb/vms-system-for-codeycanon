// Service Worker for Push Notifications

// VAPID public key (must match server configuration)
const VAPID_PUBLIC_KEY = 'BMwjbHQJYbALDOGyRVOtXhGWNfUmm552XQVbhl30Nwcst623GnzznvZSvvQtBTakwi2zgVLJsckGiwFke7oCi6s';

self.addEventListener('push', function(event) {
    console.log('Push received:', event.data ? event.data.text() : 'No data');

    let data = {
        title: 'Notification',
        body: 'You have a new message',
        icon: '/admin_resource/assets/images/icons.png',
        data: { url: '/' }
    };

    if (event.data) {
        try {
            const jsonData = event.data.json();
            data.title = jsonData.title || data.title;
            data.body = jsonData.body || data.body;
            data.icon = jsonData.icon || data.icon;
            data.data = jsonData.data || jsonData.url || data.data;
        } catch (err) {
            data.body = event.data.text();
        }
    }

    event.waitUntil(
        self.registration.showNotification(data.title, {
            body: data.body,
            icon: data.icon,
            data: typeof data.data === 'object' ? (data.data.url || '/') : data.data,
            vibrate: [200, 100, 200],
            requireInteraction: true
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
