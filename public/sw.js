self.addEventListener('push', function (e) {
    if (!(self.Notification && self.Notification.permission === 'granted')) {
        return;
    }

    if (e.data) {
        var msg = e.data.json();
        e.waitUntil(self.registration.showNotification(msg.title, {
            body: msg.body,
            icon: msg.icon || '/favicon.ico',
            data: msg.data || {},
            actions: msg.actions || []
        }));
    }
});

self.addEventListener('notificationclick', function (e) {
    e.notification.close();

    var targetUrl = '/';
    if (e.notification.data && e.notification.data.url) {
        targetUrl = e.notification.data.url;
    } else if (e.action) {
        targetUrl = e.action;
    }

    e.waitUntil(
        clients.matchAll({ type: 'window', includeUncontrolled: true }).then(function (clientList) {
            for (var i = 0; i < clientList.length; i++) {
                var client = clientList[i];
                if (client.url.includes(targetUrl) && 'focus' in client) {
                    return client.focus();
                }
            }
            if (clients.openWindow) {
                return clients.openWindow(targetUrl);
            }
        })
    );
});
