<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PhoneUser;
use App\Models\Listing;
use App\Models\ListingLike;

class PhoneUserLikeController extends Controller
{
    // GET version
    public function likedListingsById($user_id)
    {
        $user = PhoneUser::find($user_id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $likedListings = $user->likedListings()->with('category', 'breed')->get();

        
        return response()->json($likedListings);
    }

    public function likeListing(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'user_id' => 'required|exists:phone_users,id', // Ensure the user exists
            'listing_id' => 'required|exists:listings,id', // Ensure the listing exists
        ]);

        // Find the user and listing from the database
        $user = PhoneUser::find($request->user_id);
        $listing = Listing::find($request->listing_id);

        // Check if the user already liked the listing
        $existingLike = ListingLike::where('phone_user_id', $user->id)
            ->where('listing_id', $listing->id)
            ->first();

        // If the user already liked this listing, we will not add a duplicate
        if ($existingLike) {
            return response()->json([
                'message' => 'You have already liked this listing.',
            ], 400);
        }

        // Otherwise, create a new like record
        ListingLike::create([
            'phone_user_id' => $user->id,
            'listing_id' => $listing->id,
        ]);

        return response()->json([
            'message' => 'Listing liked successfully!',
            'user_id' => $user->id,
            'listing_id' => $listing->id,
        ], 200);
    }
     public function unlikeListing(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'user_id' => 'required|exists:phone_users,id', // Ensure the user exists
            'listing_id' => 'required|exists:listings,id', // Ensure the listing exists
        ]);

        // Find the user and listing from the database
        $user = PhoneUser::find($request->user_id);
        $listing = Listing::find($request->listing_id);

        // Check if the user has liked this listing
        $existingLike = ListingLike::where('phone_user_id', $user->id)
            ->where('listing_id', $listing->id)
            ->first();

        // If the like exists, we can delete it
        if ($existingLike) {
            $existingLike->delete(); // Remove the like
            return response()->json([
                'message' => 'Listing unliked successfully!',
                'user_id' => $user->id,
                'listing_id' => $listing->id,
            ], 200);
        }

        // If the user has not liked this listing, return a message
        return response()->json([
            'message' => 'You have not liked this listing yet.',
        ], 400);
    }

}
