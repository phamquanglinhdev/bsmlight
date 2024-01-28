const {initializeApp} = require("firebase/app");
const {getMessaging} = require("firebase/messaging");
window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });

const firebaseConfig = {
    apiKey: "AIzaSyAfKNUuDB61qCLLlN-y68uTPKA9tNtbTkw",
    authDomain: "bsm-light-vn.firebaseapp.com",
    databaseURL: "https://bsm-light-vn-default-rtdb.asia-southeast1.firebasedatabase.app",
    projectId: "bsm-light-vn",
    storageBucket: "bsm-light-vn.appspot.com",
    messagingSenderId: "572902198465",
    appId: "1:572902198465:web:9b95e480902d03f521d840",
    measurementId: "G-283HH5Q1Q1"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);


// Initialize Firebase Cloud Messaging and get a reference to the service
const messaging = getMessaging(app);

function requestPermission() {
    console.log('Requesting permission...');
    Notification.requestPermission().then((permission) => {
        if (permission === 'granted') {
            console.log('Notification permission granted.');
        }
    });
}

requestPermission()

console.log(messaging,app)

import { getToken } from "firebase/messaging";

const validKey = 'BPqkXeNNBl4HDSourWAYvF48UzB8KiCB2Dc7mDSoV-x5lOi9P4j6YbTtZluTCJmtAgQ3sP34nSkDq2aR5Huui_I';
getToken(messaging, { vapidKey: validKey }).then((currentToken) => {
    if (currentToken) {
        console.log(currentToken)
    } else {
        console.log('No registration token available. Request permission to generate one.');
    }
}).catch((err) => {
    console.log('An error occurred while retrieving token. ', err);
});




