<?php

namespace App\Http\Controllers;

use App\Models\ListingInteraction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ListingIntractionController extends Controller

{
   public function contactClick($id)
    {
        $user = auth('phoneUser')->user(); // ✅ Correct guard
    
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Not logged in or not a phone user']);
        }
    
        $userId = $user->id;
    
        // Cache key to prevent multiple counts
        $cacheKey = "contact_clicked_{$userId}_{$id}";
    
        if (Cache::has($cacheKey)) {
            return response()->json(['success' => false, 'message' => 'Already clicked']);
        }
    
        Cache::put($cacheKey, true, now()->addDays(1)); // You can change the duration if needed
    
        $interaction = ListingInteraction::firstOrCreate(
            ['listing_id' => $id],
            ['view_count' => 0, 'contact_clicks' => 0, 'share_clicks' => 0]
        );
    
        $interaction->increment('contact_clicks');
    
        return response()->json(['success' => true]);
    }


    
   public function shareClick($id)
    {
        $user = auth('phoneUser')->user(); // ✅ Use correct phone user guard
    
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Not logged in or not a phone user']);
        }
    
        $userId = $user->id;
    
        // Cache key to prevent multiple clicks
        $cacheKey = "share_clicked_{$userId}_{$id}";
    
        if (Cache::has($cacheKey)) {
            return response()->json(['success' => false, 'message' => 'Already clicked']);
        }
    
        Cache::put($cacheKey, true, now()->addDays(1)); // Change duration as needed
    
        $interaction = ListingInteraction::firstOrCreate(
            ['listing_id' => $id],
            ['view_count' => 0, 'contact_clicks' => 0, 'share_clicks' => 0]
        );
    
        $interaction->increment('share_clicks');
    
        return response()->json(['success' => true]);
    }
    public function countView($id)
    {
        $user = auth('phoneUser')->user(); // ✅ Using phone user guard
    
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Not logged in or not a phone user']);
        }
    
        $userId = $user->id;
    
        // Cache key to track views per user per listing
        $cacheKey = "viewed_listing_{$userId}_{$id}";
    
        if (Cache::has($cacheKey)) {
            return response()->json(['success' => false, 'message' => 'Already viewed']);
        }
    
        Cache::put($cacheKey, true, now()->addHours(6)); // ⏰ change to your preferred duration
    
        $interaction = ListingInteraction::firstOrCreate(
            ['listing_id' => $id],
            ['view_count' => 0, 'contact_clicks' => 0, 'share_clicks' => 0]
        );
    
        $interaction->increment('view_count');
    
        return response()->json(['success' => true]);
    }
}