<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Firebase Web SDK (client)
    |--------------------------------------------------------------------------
    |
    | Used for phone auth on the registration page. Values from Firebase
    | Console → Project settings → Your apps. Set in .env (not committed).
    |
    */

    'client' => [
        'apiKey' => env('FIREBASE_API_KEY'),
        'authDomain' => env('FIREBASE_AUTH_DOMAIN'),
        'projectId' => env('FIREBASE_PROJECT_ID'),
        'storageBucket' => env('FIREBASE_STORAGE_BUCKET'),
        'messagingSenderId' => env('FIREBASE_MESSAGING_SENDER_ID'),
        'appId' => env('FIREBASE_APP_ID'),
        'measurementId' => env('FIREBASE_MEASUREMENT_ID'),
    ],

];
