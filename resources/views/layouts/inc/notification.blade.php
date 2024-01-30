{{--<script src="{{asset('js/app.js')}}"></script>--}}
{{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>--}}
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase.js"></script>
<script>
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


    firebase.initializeApp(firebaseConfig);


    const messaging = firebase.messaging();

    function startFCM() {
        messaging
            .requestPermission()
            .then(function () {
                return messaging.getToken()
            })
            .then(function (response) {
                console.log("token:",response);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    }
                });
                $.ajax({
                    url: '{{ url("/notification/save-token") }}',
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
            console.log(error);
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

    startFCM();
</script>
