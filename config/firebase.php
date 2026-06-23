<?php

$clientPath = base_path('firebase/firebase.json');

$client = [];
if (is_readable($clientPath)) {
    $decoded = json_decode(file_get_contents($clientPath), true);
    if (is_array($decoded)) {
        $client = $decoded;
    }
}

if ($client === []) {
    $client = [
        'apiKey' => env('FIREBASE_API_KEY'),
        'authDomain' => env('FIREBASE_AUTH_DOMAIN'),
        'projectId' => env('FIREBASE_PROJECT_ID'),
        'storageBucket' => env('FIREBASE_STORAGE_BUCKET'),
        'messagingSenderId' => env('FIREBASE_MESSAGING_SENDER_ID'),
        'appId' => env('FIREBASE_APP_ID'),
        'measurementId' => env('FIREBASE_MEASUREMENT_ID'),
    ];
}

return [

    /*
    |--------------------------------------------------------------------------
    | Firebase Web SDK (client)
    |--------------------------------------------------------------------------
    |
    | Loaded from firebase/firebase.json (gitignored). Falls back to .env if
    | the file is missing. Used for phone auth on the registration page.
    |
    */

    'client' => $client,

];
