<?php 

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Listing;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;

class ListingApiController extends Controller
{

public function index(Request $request)
{
        $query = Listing::query();
    
        // Apply category filter if category parameter exists
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }
    
        // Eager load relationships and get the listings, ordered by latest
        $listings = $query->with(['category', 'breed', 'users'])->latest()->get();
    
        return response()->json($listings);
    }


public function storeTextFields(Request $request)
{
    \Log::info('Step 1: Store text-based fields');

    // Validation rules (excluding images)
    $rules = [
        'title' => 'nullable|string',
        'user_id' => 'nullable|exists:phone_users,id',
        'category_id' => 'required|exists:categories,id',
        'breed_id' => 'nullable|exists:breeds,id',
        'age_years' => 'nullable|integer',
        'age_months' => 'nullable|integer',
        'gaban' => 'nullable|in:no,yes',
        'suwa' => 'nullable|integer',
        'quantity' => 'nullable|integer',
        'min_age_years' => 'nullable|integer',
        'min_age_months' => 'nullable|integer',
        'max_age_years' => 'nullable|integer',
        'max_age_months' => 'nullable|integer',
        'milk_quantity' => 'nullable|numeric',
        'teeth' => 'nullable|integer',
        'min_teeth' => 'nullable|integer',
        'max_teeth' => 'nullable|integer',
        'weight' => 'nullable|numeric',
        'min_weight' => 'nullable|numeric',
        'max_weight' => 'nullable|numeric',
        'total_price' => 'nullable|numeric',
        'price_per_animal' => 'nullable|numeric',
        'price_per_kg' => 'nullable|numeric',
        'price' => 'nullable|numeric',
        'gender' => 'nullable|in:male,female,both',
        'province' => 'required|string',
        'city' => 'required|string',
        'contact_number' => 'required|string',
        'address' => 'required|string',
        'detail' => 'nullable|string',
        'is_featured' => 'nullable|boolean',
        'height' => 'nullable|string',
        'max_height' => 'nullable|integer',
        'min_height' => 'nullable|integer',
        'sath_janwar' => 'nullable|string',
        'khasi' => 'nullable|in:yes,no',
    ];

    // Conditionally require quantity
    $catId = $request->input('category_id');
    if (in_array($catId, [3, 4, 7])) {
        $rules['quantity'] = 'required|integer';
    }

    try {
        $validated = $request->validate($rules);
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Validation failed.',
            'errors' => $e->errors(),
        ], 422);
    }

    $listingData = collect($validated)->except('user_id')->toArray();
    $listing = \App\Models\Listing::create($listingData);

    if (!empty($validated['user_id'])) {
        $listing->users()->attach($validated['user_id']);
    }

    return response()->json([
        'success' => true,
        'message' => 'Listing text fields saved successfully.',
        'listing_id' => $listing->id,
        'listing' => $listing->fresh(),
    ], 201);
}


public function uploadImages(Request $request, $listingId)
{
    \Log::info('Step 2: Upload images for listing ID: ' . $listingId);

    $request->validate([
        'images' => 'required|array',
        'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $listing = \App\Models\Listing::findOrFail($listingId);

    $imagePaths = [];
    foreach ($request->file('images') as $image) {
        $path = $image->store('uploads/listings', 'public');
        $imagePaths[] = $path;
    }

    $existingImages = json_decode($listing->images ?? '[]', true);
    $listing->images = json_encode(array_merge($existingImages, $imagePaths));
    $listing->save();

    

    return response()->json([
        'success' => true,
        'message' => 'Images uploaded successfully.',
        'images' => $imagePaths,
    ]);
}

public function updateListingById(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'title' => 'nullable|string',
        'user_id' => 'nullable|exists:phone_users,id',
        'category_id' => 'required|exists:categories,id',
        'breed_id' => 'nullable|exists:breeds,id',
        'age_years' => 'nullable|integer',
        'age_months' => 'nullable|integer',
        'gaban' => 'nullable|in:no,yes',
        'suwa' => 'nullable|integer',
        'quantity' => 'nullable|integer',
        'min_age_years' => 'nullable|integer',
        'min_age_months' => 'nullable|integer',
        'max_age_years' => 'nullable|integer',
        'max_age_months' => 'nullable|integer',
        'milk_quantity' => 'nullable|numeric',
        'teeth' => 'nullable|integer',
        'min_teeth' => 'nullable|integer',
        'max_teeth' => 'nullable|integer',
        'weight' => 'nullable|numeric',
        'min_weight' => 'nullable|numeric',
        'max_weight' => 'nullable|numeric',
        'total_price' => 'nullable|numeric',
        'price_per_animal' => 'nullable|numeric',
        'price_per_kg' => 'nullable|numeric',
        'price' => 'nullable|numeric',
        'gender' => 'nullable|in:male,female,both',
        'province' => 'required|string',
        'city' => 'required|string',
        'contact_number' => 'required|string',
        'address' => 'required|string',
        'detail' => 'nullable|string',
        'is_featured' => 'nullable|boolean',
        'height' => 'nullable|string',
        'max_height' => 'nullable|integer',
        'min_height' => 'nullable|integer',
        'sath_janwar' => 'nullable|string',
        'khasi' => 'nullable|in:yes,no',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'Validation failed.',
            'errors' => $validator->errors(),
        ], 400);
    }

    $listing = Listing::findOrFail($id);

    // ✅ JSON-based request
   $data = $validator->validated();
$listing->update($data);



    return response()->json([
        'success' => true,
        'message' => 'Listing updated successfully.',
        'listing' => $listing->fresh(), // gets the updated version from DB
    ]);
}


public function toggleLike(Request $request, $listingId)
{
    $user = $request->user(); // this assumes auth:sanctum
    $listing = Listing::findOrFail($listingId);

    if ($user->likedListings()->where('listing_id', $listingId)->exists()) {
        $user->likedListings()->detach($listingId);
        return response()->json(['message' => 'Listing unliked']);
    } else {
        $user->likedListings()->attach($listingId);
        return response()->json(['message' => 'Listing liked']);
    }
}
public function markAsSold($id)
{
    $listing = Listing::find($id);

    if (!$listing) {
        return response()->json(['message' => 'Listing not found'], 404);
    }

    $listing->is_sold = true; // Marking the listing as sold
    $listing->save();

    return response()->json([
        'message' => 'Listing marked as sold', 
        'listing' => $listing
    ]);
}

public function destroy($id)
{
    $listing = Listing::find($id);

    if (!$listing) {
        return response()->json(['message' => 'Listing not found'], 404);
    }

    $listing->delete();

    return response()->json(['message' => 'Listing deleted successfully']);
}



public function testing(Request $request){
    dd("test");
    exit();
}

}