<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ListingLike;
use Illuminate\Support\Facades\Auth;

class ListingLikeController extends Controller
{
    // Apply phoneUser auth middleware
    public function __construct()
    {
        $this->middleware('auth:phoneUser');
    }

    public function toggle(Request $request)
{
    $request->validate([
        'listing_id' => 'required|integer|exists:listings,id',
    ]);

    $userId = Auth::guard('phoneUser')->id();

    try {
        $like = ListingLike::where('phone_user_id', $userId)
            ->where('listing_id', $request->listing_id)
            ->first();

        if ($like) {
            $like->delete();
            $likedIds = ListingLike::where('phone_user_id', $userId)->pluck('listing_id');
            return response()->json([
                'status' => 'unliked',
                'liked_listing_ids' => $likedIds,
                'message' => 'Listing removed from liked.'
            ]);
        } else {
            ListingLike::create([
                'phone_user_id' => $userId,
                'listing_id' => $request->listing_id,
            ]);
            $likedIds = ListingLike::where('phone_user_id', $userId)->pluck('listing_id');
            return response()->json([
                'status' => 'liked',
                'liked_listing_ids' => $likedIds,
                'message' => 'Listing added to liked.'
            ]);
        }
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Something went wrong. Please try again.',
            'error' => $e->getMessage()
        ], 500);
    }
}
}
