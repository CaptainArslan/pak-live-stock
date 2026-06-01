<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PhoneUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;


class PhoneUserAuthController extends Controller
{
    
   public function index()
   {
    $phoneUsers = PhoneUser::select('id', 'name', 'phone', 'created_at')->get();

        return response()->json([
            'status' => true,
            'message' => 'All Users fetched successfully',
            'data' => $phoneUsers
        ], 200);
    }
   public function register(Request $request)
{
    $request->validate([
        'name' => 'required',
        'phone' => 'required',
    ]);

    // Check if the user already exists
    if ($existingUser = PhoneUser::where('phone', $request->phone)->first()) {
        return response()->json([
            'status' => false,
            'message' => 'User already exists',
            'data' => [
                'id' => $existingUser->id,
                'name' => $existingUser->name,
                'phone' => $existingUser->phone,
            ],
        ], 409);
    }

    $user = PhoneUser::create([
        'name' => $request->name,
        'phone' => $request->phone,
    ]);

    return response()->json([
        'status' => true,
        'message' => 'User registered successfully',
        'data' => $user
    ], 201); // 201 Created
}


    public function login(Request $request)
    {
        $user = PhoneUser::where('phone', $request->phone)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out']);
    }

   public function user(Request $request)
    {
        $users = PhoneUser::latest()->paginate(10);
    
        return response()->json([
            'success' => true,
            'message' => 'All users fetched successfully',
            'data' => $users->items(),
            'pagination' => [
                'current_page' => $users->currentPage(),
                'last_page' => $users->lastPage(),
                'per_page' => $users->perPage(),
                'total' => $users->total(),
            ]
        ], 200);
    }
    
    public function getProfileById($id)
    {
        $user = PhoneUser::findOrFail($id);
        return response()->json(['success' => true, 'data' => $user]);
    }

    public function updateProfileById(Request $request, $id)
    {
        // Define the validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|unique:phone_users,phone,' . $id,
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 400); // 400 Bad Request
        }

        // Find the user by ID
        $user = PhoneUser::findOrFail($id);

        // Update the user's profile
        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
        ]);

        // Return the success response
        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully.',
            'user' => $user,
        ]);
    }

   public function postedAds($user_id)
{
    $user = PhoneUser::find($user_id);

    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'User not found.'
        ], 404);
    }

    // Call with() and latest() on the relationship, not the user
    $listings = $user->listings()
        ->with(['category', 'breed', 'users']) // assuming 'users' is a valid relationship
        ->latest()
        ->get();

    return response()->json($listings);
}


}
