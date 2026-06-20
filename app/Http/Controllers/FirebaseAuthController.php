<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Kreait\Firebase\Factory;

class FirebaseAuthController extends Controller
{
    public function firebaseLogin(Request $request)
    {
        $firebaseToken = $request->input('firebase_token');

        if (!$firebaseToken) {
            return redirect()->back()->withErrors(['token' => 'Firebase token is required']);
        }

        $auth = (new Factory)->withServiceAccount(base_path('firebase/firebase.json'))->createAuth();

        try {
            $verifiedIdToken = $auth->verifyIdToken($firebaseToken);
            $uid = $verifiedIdToken->claims()->get('sub');

            $firebaseUser = $auth->getUser($uid);
            $phone = $firebaseUser->phoneNumber;

            if (!$phone) {
                return redirect()->back()->withErrors(['phone' => 'Phone number not found in Firebase user']);
            }

            // Login or register
            $user = User::firstOrCreate(
                ['phone' => $phone],
                ['name' => 'Firebase User']
            );

            Auth::login($user);

            return redirect()->intended('/dashboard');
        } catch (\Throwable $e) {
            return redirect()->back()->withErrors(['login' => 'Firebase token verification failed: ' . $e->getMessage()]);
        }
    }
}
