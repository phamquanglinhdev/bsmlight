// Give the service worker access to Firebase Messaging.
// Note that you can only use Firebase Messaging here. Other Firebase libraries
// are not available in the service worker.importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');
/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
*/
firebase.initializeApp({
    apiKey: "AIzaSyAfKNUuDB61qCLLlN-y68uTPKA9tNtbTkw",
    authDomain: "bsm-light-vn.firebaseapp.com",
    databaseURL: "https://bsm-light-vn-default-rtdb.asia-southeast1.firebasedatabase.app",
    projectId: "bsm-light-vn",
    storageBucket: "bsm-light-vn.appspot.com",
    messagingSenderId: "572902198465",
    appId: "1:572902198465:web:9b95e480902d03f521d840",
    measurementId: "G-283HH5Q1Q1"
});

const messaging = firebase.messaging();

self.addEventListener('push', event => {
    const payload = event.data.json();
    const title = payload.notification.title;
    const options = {
        body: payload.notification.body,
        icon: 'https://i.pinimg.com/564x/c1/9a/1d/c19a1d3823b60a19194fe700f0524ae6.jpg',
        badge: 'path-to-badge/badge.png',
        data: payload.data,
    };

    event.waitUntil(
        self.registration.showNotification(title, options)
    );
});

self.addEventListener('notificationclick', event => {
    // Lấy thông tin từ thông báo
    const clickAction = event.notification.data.click_action;

    if (clickAction) {
        clients.openWindow(clickAction);
    }
    event.notification.close();
});
