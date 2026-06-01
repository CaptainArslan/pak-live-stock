<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Breed;

class BreedApiController extends Controller
{
    public function index()
    {
        $breeds = Breed::with('categories:id,name')->get();

        return response()->json([
            'status' => true,
            'message' => 'All breeds fetched successfully',
            'data' => $breeds
        ], 200);
    }
}
