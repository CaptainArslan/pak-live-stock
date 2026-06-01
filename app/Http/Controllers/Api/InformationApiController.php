<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Information;

class InformationApiController extends Controller
{
    public function index()
    {
        $informations = Information::orderBy('created_at', 'desc')->paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'All Information get successfully.',
            'data' => $informations,
        ]);
    }
    public function show($id)
    {
        $info = Information::find($id);
        
        if (!$info) {
            return response()->json(['success' => false, 'message' => 'Information not found.'], 404);
        }
        
        return response()->json(['success' => true, 'data' => $info]);
    }

}
