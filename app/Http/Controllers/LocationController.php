<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Models\City;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    // Get all provinces
    public function getCitiesByProvince(Request $request)
    {
        $province = Province::where('name', $request->province_name)->first();
    
        if ($province) {
            $cities = City::where('province_id', $province->id)->get(['name']);
            return response()->json($cities);
        }
    
        return response()->json([]);
    }
}
