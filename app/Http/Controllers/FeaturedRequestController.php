<?php

namespace App\Http\Controllers;

use App\Models\FeaturedRequest;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FeaturedRequestController extends Controller
{
    public function instructions($listing_id)
    {
        $listing = Listing::findOrFail($listing_id);
        return view('featured.instructions', compact('listing'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:phone_users,id',
            'listing_id' => 'required|exists:listings,id',
            'days' => 'nullable|integer',
            'rupes' => 'nullable|integer',
            'receipt_image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $imagePath = $request->file('receipt_image')->store('receipts', 'public');

        FeaturedRequest::create([
            'user_id' => auth('phoneUser')->id(),
            'listing_id' => $request->listing_id,
            'days' => $request->days,
            'rupes' => $request->rupes,
            'receipt_image' => $imagePath,
            'status' => 'pending'
        ]);

        return redirect()->route('phone-user.notifications')->with('success', 'Your request has been submitted.');
    }
    public function notifications()
    {
        $user = auth('phoneUser')->user();
    
        // Fetch pending and approved featured requests for the logged-in user
        $pendingRequests = FeaturedRequest::where('user_id', $user->id)->where('status', 'pending')->with('listing')->get();
        $approvedRequests = FeaturedRequest::where('user_id', $user->id)->where('status', 'approved')->with('listing')->get();
    
        return view('phone_user.notifications', compact('pendingRequests', 'approvedRequests'));
    }
}
