// sw.js — Service Worker

self.addEventListener('push', function(event) {
    console.log('Push received:', event.data ? event.data.text() : 'No data');

    let data = {
        title: 'Notification',
        body: 'You have a new message',
        icon: 'https://tms.nextdigihome.com/public/admin_resource/assets/images/icons.png',
        data: { url: '/' }
    };

    if (event.data) {
        try {
            const jsonData = event.data.json();
            data.title = jsonData.title || data.title;
            data.body = jsonData.body || data.body;
            data.icon = jsonData.icon || data.icon;
            data.data = jsonData.data || data.data;
        } catch (err) {
            data.body = event.data.text();
        }
    }

    event.waitUntil(
        self.registration.showNotification(data.title, {
            body: data.body,
            icon: data.icon,
            data: data.data
        })
    );
});

self.addEventListener('notificationclick', function(event) {
    event.notification.close();
    const clickUrl = event.notification.data.url || '/';
    event.waitUntil(
        clients.matchAll({ type: 'window', includeUncontrolled: true }).then(windowClients => {
            for (let client of windowClients) {
                if (client.url === clickUrl && 'focus' in client) return client.focus();
            }
            if (clients.openWindow) return clients.openWindow(clickUrl);
        })
    );
});
