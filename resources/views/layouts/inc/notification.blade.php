<script src="https://cdn.onesignal.com/sdks/web/v16/OneSignalSDK.page.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.6.7/axios.min.js"></script>
<script>
    window.OneSignalDeferred = window.OneSignalDeferred || [];

    function permissionChangeListener(e) {
        console.log(e)
    }

    OneSignalDeferred.push(function (OneSignal) {
        OneSignal.init({
            appId: "7a6addcb-f707-4a8a-bf3a-296924818284",
            safari_web_id: "web.onesignal.auto.246fdfe2-a404-4d40-aa8a-d2b211d431d5",
            notifyButton: {
                enable: true,
            },
        })

        OneSignal.getUserId().then((r) => {
            console.log("aaa",r)
        })

        OneSignal.User.PushSubscription.addEventListener("change", function (event) {
            axios.post(
                '{{url('notification/save-token')}}',
                {
                    token: event.current.id
                },
                {
                    headers: {
                        "X-CSRFToken": "{{ csrf_token() }}"
                    },
                })
                .then(function (response) {
                });
        });
    });

</script>
