<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeaturedRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Listing;


class FeaturedRequestController extends Controller
{
    // Show all pending requests in the admin panel 
    public function index()
{
    // Pending Featured Requests
    $requests = FeaturedRequest::with(['user', 'listing.category'])->where('status', 'pending')->get();

    // Approved Listings
    $approvedListings = Listing::with(['users', 'category'])
        ->where('is_featured', true)
        ->get();

    return view('admin.featured_requests.index', compact('requests', 'approvedListings'));
}




    // Store new Featured Ad Request (User Side)
    public function store(Request $request)
    {
        // Ensure user is logged in
        if (!auth('phoneUser')->check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to submit a request.');
        }

        // Validate form input
        $request->validate([
            'listing_id' => 'required|exists:listings,id',
            'user_id' => 'required|exists:phone_users,id',
            'receipt_image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Store receipt image in 'public/receipts' folder
        $imagePath = $request->file('receipt_image')->store('receipts', 'public');

        // Create a new Featured Request
        FeaturedRequest::create([
            'user_id' => $request->user_id ?? auth('phoneUser')->id(),  // Get authenticated user ID
            'listing_id' => $request->listing_id,
            'receipt_image' => $imagePath,
            'status' => 'pending'
        ]);

        // Redirect to user notifications page
        return redirect()->route('phone-user.notifications')->with('success', 'Your request has been submitted.');
    }


    // Approve Featured Ad Request (Admin Side)
    public function approve($id)
    {
        $request = FeaturedRequest::findOrFail($id);
        $request->listing->update(['is_featured' => true]); // Mark listing as featured
        $request->update(['status' => 'approved']); // Update request status

        return redirect()->back()->with('success', 'Ad has been marked as Featured.');
    }
    public function reject($id)
    {
        $request = FeaturedRequest::findOrFail($id);
        $request->listing->update(['is_featured' => false]); // Mark listing as featured
        $request->update(['status' => 'reject']); // Update request status

        return redirect()->back()->with('success', 'Ad has been rejected.');
    }
}
