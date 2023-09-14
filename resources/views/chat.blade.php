<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Chat') }}
        </h2>
    </x-slot>


    <div class="container" style="margin-bottom: 480px">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        <div class="chat-container">

                            <p class="chat chat-right">
                                <b>A :</b><br>
                                message1
                            </p>
                            <p class="chat chat-left">
                                <b>B :</b><br>
                                message 2
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="message-input-container">
        <form action="{{ route('home.createChat') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Message</label>
                <input type="text" name="message" class="form-control">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">SEND MESSAGE</button>
            </div>
        </form>
    </div>
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'></script>
    <script type="module">
        // Import the functions you need from the SDKs you need
            import { initializeApp } from "https://www.gstatic.com/firebasejs/9.23.0/firebase-app.js";
            // TODO: Add SDKs for Firebase products that you want to use
            // https://firebase.google.com/docs/web/setup#available-libraries
          
            // Your web app's Firebase configuration
            const firebaseConfig = {
              apiKey: "AIzaSyDIFoAQmDsAm1sqcXupSZzAORMS9OkH8qg",
              authDomain: "chat-demo-28c62.firebaseapp.com",
              projectId: "chat-demo-28c62",
              storageBucket: "chat-demo-28c62.appspot.com",
              messagingSenderId: "727583062273",
              appId: "1:727583062273:web:d64df4495620529ed7c300"
            };
          
            // Initialize Firebase
            const app = initializeApp(firebaseConfig);
//  console.log(app);
        // Retrieve Firebase Messaging object.
        console.log(messaging);
    const messaging = firebase.messaging();

    // Add the public key generated from the console here.
    messaging.usePublicVapidKey("BNi8WFY0HVBE2YvPXCfj7wDGbURGAh6rD57klttmetVL-PDYCnPNOgvUfC_RZquDF6uXjS5f78PXAcnFI9KuNTE");


    function sendTokenToServer(fcm_token) {
        const user_id = '{{auth()->user()->id}}';
        //console.log($user_id);
        axios.post('/api/save-token', {
            fcm_token, user_id
        })
            .then(res => {
                console.log(res);
            })

    }

    function retreiveToken(){
        messaging.getToken().then((currentToken) => {
            if (currentToken) {
                sendTokenToServer(currentToken);
                // updateUIForPushEnabled(currentToken);
            } else {
                // Show permission request.
                //console.log('No Instance ID token available. Request permission to generate one.');
                // Show permission UI.
                //updateUIForPushPermissionRequired();
                //etTokenSentToServer(false);
                alert('You should allow notification!');
            }
        }).catch((err) => {
            console.log(err.message);
            showToken('Error retrieving Instance ID token. ', err);
            // setTokenSentToServer(false);
        });
    }
    retreiveToken();
    messaging.onTokenRefresh(()=>{
        retreiveToken();


    });

    messaging.onMessage((payload)=>{
        console.log('Message received');
        console.log(payload);

        location.reload();
    });

    </script>

</x-app-layout>