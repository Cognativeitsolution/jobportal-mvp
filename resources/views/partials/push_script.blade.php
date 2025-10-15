<script src="{{ asset('assets/global/js/firebase/firebase-app.js') }}"></script>
<script src="{{ asset('assets/global/js/firebase/firebase-messaging.js') }}"></script>

<script>
    "use strict";

    // var permission = null;
    // var authenticated = '{{ auth()->user() ? true : false }}';

    // var pushNotify = @json(gs('pn'));
    // var firebaseConfig = @json(gs('firebase_config'));

    // function pushNotifyAction() {
    //     permission = Notification.permission;

    //     if (!('Notification' in window)) {
    //         notify('info', 'Push notifications not available in your browser. Try Chromium.')
    //     } else if (permission === 'denied' || permission == 'default') { //Notice for users dashboard
    //         $('.notice').append(`<div class="alert alert--custom mb-4 alert--info" role="alert">
    //                                 <div class="alert__icon">   
    //                                     <i class='las la-bell'></i>
    //                                 </div>
    //                                 <div class="alert__content">
    //                                     <h6 class="alert__title">
    //                                         @lang('Please Allow / Reset Browser Notification')
    //                                     </h6>
    //                                     <p>
    //                                         @lang('If you want to get push notification then you have to allow notification from your browser')
    //                                     </p>
    //                                 </div>
    //                             </div>`);
    //     }
    // }

    // //If enable push notification from admin panel
    // if (pushNotify == 1) {
    //     pushNotifyAction();
    // }

    // //When users allow browser notification
    // if (permission != 'denied' && firebaseConfig) {
    //     //Firebase
    //     firebase.initializeApp(firebaseConfig);
    //     const messaging = firebase.messaging();

    //     navigator.serviceWorker.register("{{ asset('assets/global/js/firebase/firebase-messaging-sw.js') }}")
    //         .then((registration) => {
    //             messaging.useServiceWorker(registration);

    //             function initFirebaseMessagingRegistration() {
    //                 messaging
    //                     .requestPermission()
    //                     .then(function() {
    //                         return messaging.getToken()
    //                     })
    //                     .then(function(token) {
    //                         $.ajax({
    //                             url: '{{ route('user.add.device.token') }}',
    //                             type: 'POST',
    //                             data: {
    //                                 token: token,
    //                                 '_token': "{{ csrf_token() }}"
    //                             },
    //                             success: function(response) {},
    //                             error: function(err) {},
    //                         });
    //                     }).catch(function(error) {});
    //             }
    //             messaging.onMessage(function(payload) {
    //                 const title = payload.notification.title;
    //                 const options = {
    //                     body: payload.notification.body,
    //                     icon: payload.data.icon,
    //                     image: payload.notification.image,
    //                     click_action: payload.data.click_action,
    //                     vibrate: [200, 100, 200]
    //                 };
    //                 new Notification(title, options);
    //             });

    //             //For authenticated users
    //             if (authenticated) {
    //                 initFirebaseMessagingRegistration();
    //             }

    //         });
    // }

    "use strict";

    var permission = null;
    var authenticated = '{{ auth()->user() ? true : false }}';
    var pushNotify = @json(gs('pn'));
    var firebaseConfig = @json(gs('firebase_config'));

    function pushNotifyAction() {
        permission = Notification.permission;

        if (!('Notification' in window)) {
            notify('info', 'Push notifications not available in your browser. Try Chromium.');
        } else if (permission === 'denied' || permission == 'default') {
            $('.notice').append(`
            <div class="alert alert--custom mb-4 alert--info" role="alert" id="notifyAlert">
                <div class="alert__icon">   
                    <i class='las la-bell'></i>
                </div>
                <div class="alert__content">
                    <h6 class="alert__title">
                        @lang('Please Allow / Reset Browser Notification')
                    </h6>
                    <p>
                        @lang('Click here to enable notifications in your browser.')
                    </p>
                </div>
            </div>
        `);
        }
    }

    if (pushNotify == 1) {
        pushNotifyAction();
    }

    if (firebaseConfig) {
        firebase.initializeApp(firebaseConfig);
        const messaging = firebase.messaging();

        navigator.serviceWorker.register("{{ asset('assets/global/js/firebase/firebase-messaging-sw.js') }}")
            .then((registration) => {
                messaging.useServiceWorker(registration);

                function initFirebaseMessagingRegistration() {
                    messaging
                        .requestPermission()
                        .then(() => messaging.getToken())
                        .then((token) => {
                            $.ajax({
                                url: '{{ route('user.add.device.token') }}',
                                type: 'POST',
                                data: {
                                    token: token,
                                    '_token': "{{ csrf_token() }}"
                                },
                            });
                        })
                        .catch((error) => console.error(error));
                }

                messaging.onMessage(function (payload) {
                    const title = payload.notification.title;
                    const options = {
                        body: payload.notification.body,
                        icon: payload.data.icon,
                        image: payload.notification.image,
                        click_action: payload.data.click_action,
                        vibrate: [200, 100, 200]
                    };
                    new Notification(title, options);
                });

                // ✅ Jab alert pe click ho to permission popup khul jaye
                $(document).on('click', '#notifyAlert', function () {
                    initFirebaseMessagingRegistration();
                });

                // ✅ Agar user pehle se authenticated hai
                if (authenticated && permission === 'granted') {
                    initFirebaseMessagingRegistration();
                }
            });
    }
</script>