<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Listing;
use Illuminate\Support\Facades\Auth;
use App\Models\ListingLike;
use App\Http\Controllers\ListingLikeController;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::with('listings')->whereIn('main_cat', ['Livestock', 'Pets', 'Birds', 'Other'])->get();

        $listings = Listing::where('is_sold', false) // Exclude sold listings
            ->orderByDesc('is_featured')          // Featured listings first
            ->orderByDesc('created_at')           // Then latest listings
            ->get();

        $likedListingIds = [];

        if (Auth::guard('phoneUser')->check()) {
            $likedListingIds = ListingLike::where('phone_user_id', Auth::guard('phoneUser')->id())
                ->pluck('listing_id')
                ->toArray();
        }

        return view('welcome', compact('categories', 'listings', 'likedListingIds'));
    }
}
