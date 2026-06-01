<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Models\City;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    // Get all provinces
    public function getProvinces()
    {
        // Fetch all provinces
        $provinces = Province::all();
        
        // Return the response
        return response()->json([
            'status' => 'success',
            'message' => 'All Provinces Get successfully.',
            'data' => $provinces
        ], 200);
    }

    // Get all cities
    public function getCities()
    {
        // Fetch all cities
        $cities = City::all();
        
        // Return the response
        return response()->json([
            'status' => 'success',
            'message' => 'All Cities Get successfully.',
            'data' => $cities
        ], 200);
    }

    // Get cities by province_id
    public function getCitiesByProvince($province_id)
    {
        // Fetch cities belonging to the given province ID
        $cities = City::where('province_id', $province_id)->get();
        
        // Return the response
        return response()->json([
            'status' => 'success',
            'data' => $cities
        ], 200);
    }
}
