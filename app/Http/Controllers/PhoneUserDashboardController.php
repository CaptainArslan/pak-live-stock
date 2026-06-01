<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PhoneUser;
use App\Models\Listing;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;


class PhoneUserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::guard('phoneUser')->user();
        return view('phone_user.dashboard', compact('user'));
    }

    public function profile()
    {
        $user = Auth::guard('phoneUser')->user();
        return view('phone_user.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::guard('phoneUser')->user();
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|unique:phone_users,phone,' . $user->id
        ]);

        $user->update($request->all());
        return back()->with('success', 'Profile updated successfully.');
    }

    public function likedAds()
    {
        $user = Auth::guard('phoneUser')->user();
        $likedListings = $user->likedListings;  // Assuming you have a relationship for liked ads
        return view('phone_user.liked_ads', compact('likedListings'));
    }

    public function postedAds()
    {
        $user = Auth::guard('phoneUser')->user();
        $postedAds = Listing::where('phone_user_id', $user->id)->latest()->get()->paginate(10);
        return view('phone_user.posted_ads', compact('postedAds'));
    }

    public function notifications()
    {
        $user = Auth::guard('phoneUser')->user();
        $notifications = Notification::where('user_id', $user->id)->latest()->get();
        return view('phone_user.notifications', compact('notifications'));
    }
}
