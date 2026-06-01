<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryApiController extends Controller
{
    public function index()
    {
        $categories = Category::select('id', 'name', 'main_cat' ,'image', 'created_at')->get();

        return response()->json([
            'status' => true,
            'message' => 'All categories fetched successfully',
            'data' => $categories
        ], 200);
    }
}
