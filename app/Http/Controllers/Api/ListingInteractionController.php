<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller; 
use App\Models\ListingInteraction;
use Illuminate\Http\Request;

class ListingInteractionController extends Controller
{
    public function viewCount($id)
    {
        $interaction = ListingInteraction::firstOrCreate(['listing_id' => $id]);
        $interaction->increment('view_count');

        return response()->json(['success' => true, 'view_count' => $interaction->view_count]);
    }

    public function contactClick($id)
    {
        $interaction = ListingInteraction::firstOrCreate(['listing_id' => $id]);
        $interaction->increment('contact_clicks');

        return response()->json(['success' => true, 'contact_clicks' => $interaction->contact_clicks]);
    }

    public function shareClick($id)
    {
        $interaction = ListingInteraction::firstOrCreate(['listing_id' => $id]);
        $interaction->increment('share_clicks');

        return response()->json(['success' => true, 'share_clicks' => $interaction->share_clicks]);
    }
}
