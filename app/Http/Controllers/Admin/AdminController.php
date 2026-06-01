<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Listing;
use App\Models\Category;
use App\Models\Breed;
use App\Models\PhoneUser;
use App\Models\FeaturedRequest;
use App\Models\ListingInteraction;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
{
    $userCount = PhoneUser::count();
    $totalCategories = Category::count();
    $totalBreeds = Breed::count();
    $totalListings = Listing::count();

    $approvedAds = Listing::where('is_featured', '1')->count();
    $pendingAds = FeaturedRequest::where('status', 'pending')->count();
    $rejectedAds = FeaturedRequest::where('status', 'rejected')->count();

    $recentUsers = PhoneUser::select('id', 'name', 'phone')->latest()->take(4)->get();

    $totalViews = ListingInteraction::sum('view_count');
    $totalContactClicks = ListingInteraction::sum('contact_clicks');
    $totalShareClicks = ListingInteraction::sum('share_clicks');
    
    $monthlyViews = ListingInteraction::selectRaw('MONTH(created_at) as month, SUM(view_count) as total')
        ->groupBy('month')
        ->pluck('total', 'month');
        
    $monthlyContacts = ListingInteraction::selectRaw('MONTH(created_at) as month, SUM(contact_clicks) as total')
        ->groupBy('month')
        ->pluck('total', 'month');
        
    $monthlyShares = ListingInteraction::selectRaw('MONTH(created_at) as month, SUM(share_clicks) as total')
        ->groupBy('month')
        ->pluck('total', 'month');
    
    // Fill missing months with 0
    $viewsByMonth = $contactsByMonth = $sharesByMonth = array_fill(1, 12, 0);
    
    foreach ($monthlyViews as $month => $count) {
        $viewsByMonth[$month] = $count;
    }
    foreach ($monthlyContacts as $month => $count) {
        $contactsByMonth[$month] = $count;
    }
    foreach ($monthlyShares as $month => $count) {
        $sharesByMonth[$month] = $count;
    }


    return view('dashboard', compact(
        'userCount',
        'totalCategories',
        'totalBreeds',
        'totalListings',
        'approvedAds',
        'pendingAds',
        'rejectedAds',
        'recentUsers',
        'totalViews',
        'totalContactClicks',
        'totalShareClicks',
        'viewsByMonth',
        'contactsByMonth',
        'sharesByMonth'
    ));
}

}
