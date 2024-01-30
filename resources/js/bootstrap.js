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

import {initializeApp} from 'firebase/app';
import {getMessaging, getToken} from "firebase/messaging";
import axios from 'axios';

// Thông tin cấu hình Firebase của bạn
// const firebaseConfig = {
//     apiKey: process.env.FIREBASE_API_KEY,
//     authDomain: process.env.FIREBASE_AUTH_DOMAIN,
//     projectId: process.env.FIREBASE_PROJECT_ID,
//     storageBucket: process.env.FIREBASE_STORAGE_BUCKET,
//     messagingSenderId: process.env.FIREBASE_MESSAGING_SENDER_ID,
//     appId: process.env.FIREBASE_APP_ID
// };

const firebaseConfig = {
    apiKey: 'AIzaSyAfKNUuDB61qCLLlN-y68uTPKA9tNtbTkw',
    authDomain: 'bsm-light-vn.firebaseapp.com',
    projectId: 'bsm-light-vn',
    storageBucket: 'bsm-light-vn.appspot.com',
    messagingSenderId: '572902198465',
    appId: '1:572902198465:web:9b95e480902d03f521d840'
};

console.log("firebaseConfig:", firebaseConfig);

// Khởi tạo ứng dụng Firebase
const firebaseApp = initializeApp(firebaseConfig);

const getFCMToken = async () => {
    try {
        const messaging = getMessaging(firebaseApp);

        console.log("messaging:", messaging)

        const currentToken = await getToken(messaging, {vapidKey: 'AIzaSyAfKNUuDB61qCLLlN-y68uTPKA9tNtbTkw'});
        //
        console.log("currentToken:", currentToken)
        // if (currentToken) {
        //     console.log('FCM Token:', currentToken);
        //     // Gửi token này lên máy chủ Laravel
        //     axios.post('/save-fcm-token', {fcm_token: currentToken})
        //         .then(response => {
        //             console.log(response.data.message);
        //         })
        //         .catch(error => {
        //             console.error('Error saving FCM token:', error);
        //         });
        // } else {
        //     console.log('No registration token available. Request permission to generate one.');
        // }
    } catch (error) {
        console.error('An error occurred while retrieving token:', error);
    }
};

getFCMToken().then();

if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/firebase-messaging-sw.js',{
            scope: '/'
        })
            .then((registration) => {
                console.log('Firebase Messaging ServiceWorker registered with scope:', registration.scope);
            })
            .catch((error) => {
                console.error('Firebase Messaging ServiceWorker registration failed:', error);
            });
    });
}

