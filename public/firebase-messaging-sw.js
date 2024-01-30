import firebase from "firebase/compat";

importScripts('https://www.gstatic.com/firebasejs/9.6.8/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/9.6.8/firebase-messaging.js');


const firebaseConfig = {
    apiKey: "AIzaSyAfKNUuDB61qCLLlN-y68uTPKA9tNtbTkw",
    authDomain: "bsm-light-vn.firebaseapp.com",
    projectId: "bsm-light-vn",
    storageBucket: "bsm-light-vn.appspot.com",
    messagingSenderId: "572902198465",
    appId: "1:572902198465:web:9b95e480902d03f521d840"
};

firebase.initializeApp(firebaseConfig);
const messaging = firebase.messaging();

messaging.onBackgroundMessage((payload) => {
    console.log('Received background message:', payload);
    // Customize the notification here
    const notificationTitle = 'Background Message Title';
    const notificationOptions = {
        body: 'Background Message body.',
        icon: '/firebase-logo.png'
    };

    self.registration.showNotification(notificationTitle,
        notificationOptions);
});
