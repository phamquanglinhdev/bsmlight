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

firebase.initializeApp(firebaseConfig);

const messaging = firebase.messaging();

function startFCM() {
    messaging
        .requestPermission()
        .then(function () {
            return messaging.getToken()
        })
        .then(function (response) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{ route("store.token") }}',
                type: 'POST',
                data: {
                    token: response
                },
                dataType: 'JSON',
                success: function (response) {
                    alert('Token stored.');
                },
                error: function (error) {
                    alert(error);
                },
            });
        }).catch(function (error) {
        alert(error);
    });
}
messaging.onMessage(function (payload) {
    const title = payload.notification.title;
    const options = {
        body: payload.notification.body,
        icon: payload.notification.icon,
    };
    new Notification(title, options);
});

