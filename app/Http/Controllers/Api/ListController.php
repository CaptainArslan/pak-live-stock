<?php 

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Listing;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;

class ListController extends Controller
{
    
    public function store(Request $request)
    {
        \Log::info('Hit store - Step 2: Validate and save listing');
    
        // Validation rules (removed image-related rules)
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
        $quantityCategories = [3, 4, 7];
        if (in_array($catId, $quantityCategories)) {
            $rules['quantity'] = 'required|integer';
        }
    
        // Validate input
        try {
            $validated = $request->validate($rules);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed', $e->errors());
            return response()->json([
                'success' => false,
                'message' => 'The given data was invalid.',
                'errors' => $e->errors(),
                'data' => $request->all()
            ], 422);
        }
    
        // Create the listing with empty images array
        $listingData = collect($validated)->except('user_id')->toArray();
        $listingData['images'] = json_encode([]); // Initialize with empty array
        
        $listing = \App\Models\Listing::create($listingData);
    
        // Attach user if provided
        if (!empty($validated['user_id'])) {
            $listing->users()->attach($validated['user_id']);
        }
    
        // Load relationships if needed
        $listing->load(['category', 'breed', 'users']);
    
       
        return response()->json([
           "data"=>  $listing, 
       ]);
    }
    
    
    public function uploadImages(Request $request, $listingId)
    {
        \Log::info('Hit uploadImages - Adding images to listing: '.$listingId);
    
        // Validate listing exists
        $listing = \App\Models\Listing::find($listingId);
        if (!$listing) {
            return response()->json([
                'success' => false,
                'message' => 'Listing not found',
            ], 404);
        }
    
        // Validate images
        $validated = $request->validate([
            'images' => 'required|array',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:4069',
        ]);
    
        // Handle image uploads
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('uploads/listings', 'public');
                $imagePaths[] = $path;
            }
        }
    
        // Get existing images and merge with new ones
        // $existingImages = json_decode($listing->images, true) ?? [];
        // $allImages = array_merge($existingImages, $imagePaths);
    
        // Update listing with new images
        $listing->update(['images' => json_encode($imagePaths)]);
    
         return response()->json([
           "data"=>  $listing, 
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
        $listing->update($validator->validated());
    
        return response()->json([
            'success' => true,
            'message' => 'Listing data updated successfully.',
            'listing' => $listing->fresh(),
        ]);
}
    
    public function getFeaturedListings($id)
    {
         $featuredListings = Listing::where('is_featured', 1)
                                  ->where('category_id', $id)
                                  ->get();
        
        return response()->json($featuredListings);
    }
    
}