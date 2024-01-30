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
messaging.setBackgroundMessageHandler(function (payload) {
    console.log("Message received.", payload);
    const title = "Hello world is awesome";
    const options = {
        body: "Your notificaiton message .",
        icon: "/firebase-logo.png",
    };
    return self.registration.showNotification(
        title,
        options,
    );
});
