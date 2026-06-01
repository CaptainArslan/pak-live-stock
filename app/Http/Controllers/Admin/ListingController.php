<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; 
use App\Models\Breed;
use App\Models\Province;
use App\Models\Cities;
use Illuminate\Support\Facades\Auth;
use App\Models\ListingLike;
use Illuminate\Support\Facades\Route;

class ListingController extends Controller {
    
    public function index(Request $request)
    {
        $query = Listing::query();
        
        // Search by Name or Phone
        if ($request->has('search') && $request->search != null) {
            $query->where('city', 'LIKE', "%{$request->search}%");
        }
        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }
            
        // Filter by breed
        if ($request->has('breed') && $request->breed) {
            $query->where('breed_id', $request->breed);
        }
    
        // Filter by date (Created or Updated)
        if ($request->has('date') && $request->date) {
            $query->whereDate('created_at', $request->date)
                  ->orWhereDate('updated_at', $request->date);
        }
        if ($request->has('min_price') && $request->min_price != '') {
            $query->where(function ($q) use ($request) {
                $q->where('price', '>=', $request->min_price)
                  ->orWhere('total_price', '>=', $request->min_price);
            });
        }
    
        if ($request->has('max_price') && $request->max_price != '') {
            $query->where(function ($q) use ($request) {
                $q->where('price', '<=', $request->max_price)
                  ->orWhere('total_price', '<=', $request->max_price);
            });
        }

        
        $listings = $query->with('interaction')->latest()->paginate(10);
        $categories = Category::with(['listings' => function ($query) {
            $query->orderByDesc('is_featured')
                    ->orderByDesc('verified')
                    ->orderByDesc('warrenty')
                    ->orderByDesc('updated_at');
        }])->get();
        $breeds = Breed::all();
            $cities = Listing::select('city')->groupBy('city')->pluck('city');

         return view('admin.listings.index', compact('listings', 'categories', 'breeds', 'cities'));
}


    
    public function create()
    {
        $categories = Category::all();
        $breeds = Breed::whereHas('categories')->get(); 
    
        return view('postads', compact('categories', 'breeds'));
    }
    
public function getBreedsByCategory($category_id)
{
    try {
        $breeds = Breed::whereHas('categories', function ($query) use ($category_id) {
            $query->where('category_id', $category_id);
        })
        ->orderByRaw("CONVERT(name USING utf8mb4) COLLATE utf8mb4_unicode_ci ASC")
        ->get();

        return response()->json($breeds);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

    
    

    public function store(Request $request) {
        $request->validate([
            'title' => 'nullable|string',
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
            'images.*' => 'required|image|mimes:jpeg,png,jpg|max:2536',
            'is_featured' => 'nullable|boolean',
            'height' =>'nullable|string',
            'max_height' => 'nullable|integer',
            'min_height' => 'nullable|integer',
            'sath_janwar' => 'nullable|string',
            'khasi' => 'nullable|in:yes,no',
            'rate_on_call' => 'nullable|boolean',
            'verified' => 'nullable|boolean',
            'warrenty' => 'nullable|boolean',
        ]);
    
        // Handle Image Uploads
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('listings', 'public');
                $imagePaths[] = $path;
            }
        }

        $phoneUserId = auth('phoneUser')->id();  

        if (!$phoneUserId) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    
        // Create Listing
        $listing = Listing::create([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'breed_id' => $request->breed_id,
            'age_years' => $request->age_years,
            'age_months' => $request->age_months,
            'gaban' => $request->gaban,
            'suwa' => $request->suwa,
            'quantity' => $request->quantity,
            'min_age_years' => $request->min_age_years,
            'min_age_months' => $request->min_age_months,
            'max_age_years' => $request->max_age_years,
            'max_age_months' => $request->max_age_months,
            'milk_quantity' => $request->milk_quantity,
            'teeth' => $request->teeth,
            'min_teeth' => $request->min_teeth,
            'max_teeth' => $request->max_teeth,
            'weight' => $request->weight,
            'min_weight' => $request->min_weight,
            'max_weight' => $request->max_weight,
            'total_price' => $request->total_price,
            'price_per_animal' => $request->price_per_animal,
            'price_per_kg' => $request->price_per_kg,
            'price' => $request->price,
            'gender' => $request->gender,
            'province' => $request->province,
            'city' => $request->city,
            'contact_number' => $request->contact_number,
            'address' => $request->address,
            'detail' => $request->detail,
            'images' => json_encode($imagePaths),
            'is_featured' => $request->has('is_featured') ? $request->is_featured : 0,
            'user_id' => $phoneUserId,
            'height' => $request->height,
            'max_height' => $request->max_height,
            'min_height' => $request->min_height,
            'sath_janwar' => $request->sath_janwar,
            'khasi' => $request->khasi === 'no',
            'rate_on_call' =>  $request->has('rate_on_call') ? $request->rate_on_call : 0,
            'verified' =>  $request->has('verified') ? $request->verified : 0,
            'warrenty' =>  $request->has('warrenty') ? $request->warrenty : 0,

        ]);
        
        $listing->users()->attach($phoneUserId);

        return redirect()->route('thank')->with('success', 'Listing added successfully');
    }
    
    

    public function edit(Listing $listing) {
        $categories = Category::all();
        $breeds = Breed::whereHas('categories')->get(); 
        $provinces = Province::all();
    
        return view('admin.listings.edit', compact('listing', 'categories', 'breeds', 'provinces'));
    }
    
    public function editByUser(Listing $listing) {
        $categories = Category::all();
        $breeds = Breed::whereHas('categories')->get(); 
        $provinces = Province::all();
        // Get current route name
        $routeName = Route::currentRouteName();
    
        // Decide which view to load
        switch ($routeName) {
            case 'phone-user.pet-edit':
                $view = 'phone_user.pet-edit';
                break;
            case 'phone-user.bird-edit':
                $view = 'phone_user.bird-edit';
                break;
            case 'phone-user.other-edit':
                $view = 'phone_user.other-edit';
                break;
            default:
                $view = 'phone_user.edit';
        }
    
        return view($view, compact('listing', 'categories', 'breeds', 'provinces'));
    }
    

    public function update(Request $request, Listing $listing) 
    {
        \Log::info('Update Request Data:', $request->all());
    
        // Validate input
        $request->validate([
            'title' => 'nullable|string',
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
            'images.*' => 'required|image|mimes:jpeg,png,jpg|max:2536',
            'is_featured' => 'nullable|boolean',
            'height' => 'nullable|string',
            'max_height' => 'nullable|integer',
            'min_height' => 'nullable|integer',
            'sath_janwar' => 'nullable|string',
            'khasi' => 'nullable|in:yes,no',
            'rate_on_call' => 'nullable|boolean',
            'verified' => 'nullable|boolean',
            'warrenty' => 'nullable|boolean',
        ]);
    
        // Handle image uploads
        if ($request->hasFile('images')) {
            if ($listing->images) {
                foreach (json_decode($listing->images) as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
    
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('listings', 'public'); 
                $imagePaths[] = $path;
            }
            $listing->images = json_encode($imagePaths);
        }
    
        // Handle sold status update
        if ($request->has('is_sold')) {
            $listing->is_sold = $request->is_sold;
        }
    
        // Handle featured_until and is_featured logic
        if ($request->has('is_featured') && $request->is_featured) {
            if ($request->has('featured_until')) {
                $featuredUntilDate = strtotime($request->featured_until);
                $currentDate = strtotime(now());
    
                if ($featuredUntilDate < $currentDate) {
                    $listing->is_featured = 0;
                } else {
                    $listing->featured_until = $request->featured_until;
                    $listing->is_featured = 1;
                }
            } else {
                $listing->is_featured = 1;
                $listing->featured_until = null;
            }
        }
    
        // ✅ Explicitly set rate_on_call
        $listing->rate_on_call = $request->input('rate_on_call') == 1 ? 1 : 0;
    
        // Update other fields excluding manually handled ones
        $updated = $listing->update($request->except([
            '_token', '_method', 'images', 'is_featured', 'featured_until', 'is_sold', 'rate_on_call'
        ]));
    
        // Save listing (in case of any manually set fields above)
        $listing->save();
    
        \Log::info('After Update:', $listing->toArray());
        \Log::info('Update Success:', ['status' => $updated]);
    
        return $updated 
            ? redirect()->route('admin.listings.index')->with('success', 'Listing updated successfully') 
            : back()->with('error', 'Update failed, please try again.');
    }
    

    
    public function updateByUser(Request $request, Listing $listing) 
    {
        \Log::info('Update Request Data:', $request->all());
    
        // Validate input
        $request->validate([
            'title' => 'nullable|string',
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
            'images.*' => 'required|image|mimes:jpeg,png,jpg|max:2536',
            'is_featured' => 'nullable|boolean',
            'height' =>'nullable|string',
            'max_height' => 'nullable|integer',
            'min_height' => 'nullable|integer',
            'sath_janwar' => 'nullable|string',
            'khasi' => 'nullable|in:yes,no',
            'rate_on_call' => 'nullable|boolean',
        ]);
    
        // Handle image uploads
        if ($request->hasFile('images')) {
            if ($listing->images) {
                foreach (json_decode($listing->images) as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
    
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('listings', 'public'); 
                $imagePaths[] = $path;
            }
            $listing->images = json_encode($imagePaths);
        }
    
        // Handle sold status update
        if ($request->has('is_sold')) {
            $listing->is_sold = $request->is_sold;
        }
    
        // Handle featured_until and is_featured logic
        if ($request->has('is_featured') && $request->is_featured) {
            if ($request->has('featured_until')) {
                $featuredUntilDate = strtotime($request->featured_until);
                $currentDate = strtotime(now());
        
                if ($featuredUntilDate < $currentDate) {
                    $listing->is_featured = 0;
                } else {
                    $listing->featured_until = $request->featured_until;
                    $listing->is_featured = 1; // ✅ ADD THIS LINE
                }
            } else {
                // If featured_until is not provided but checkbox is checked
                $listing->is_featured = 1;$listing->featured_until = null;
            }
        }
    
    
        // ✅ Explicitly set rate_on_call
        $listing->rate_on_call = $request->input('rate_on_call') == 1 ? 1 : 0;
    
        // Update other fields excluding manually handled ones
        $updated = $listing->update($request->except([
            '_token', '_method', 'images', 'is_featured', 'featured_until', 'is_sold', 'rate_on_call'
        ]));// Save the updated listing
        $listing->save();
    
        \Log::info('After Update:', $listing->toArray());
        \Log::info('Update Success:', ['status' => $updated]);
    
        return $updated 
            ? redirect()->route('phone-user.posted-ads')->with('success', 'Listing updated successfully') 
            : back()->with('error', 'Update failed, please try again.');
    }

    
    public function show($id)
    {
        $listing = Listing::findOrFail($id);
        $phoneUser = auth()->user();
    
        // Get related listings (same category, excluding current listing)
        $relatedListings = Listing::where('id', '!=', $listing->id)
            ->where('category_id', $listing->category_id) 
            ->take(10)
            ->with('interaction')
            ->latest()
            ->get();
    
        return view('listing', compact('listing', 'phoneUser', 'relatedListings'));
    }

    
    

    public function destroy(Listing $listing) {
        $listing->delete();
        return redirect()->route('admin.listings.index')->with('success', 'Listing deleted successfully');
    }

public function petListingFront(Request $request)
{
    return $this->prepareListingView($request, 'petlistingFront', 'Pets');
}

public function birdListingFront(Request $request)
{
    return $this->prepareListingView($request, 'birdlistingFront', 'Birds');
}

public function otherListingFront(Request $request)
{
    return $this->prepareListingView($request, 'otherlistingFront', 'Other');
}

public function listingFront(Request $request)
{
    return $this->prepareListingView($request, 'listingFront', 'Livestock' );
}


private function prepareListingView(Request $request, $viewName, $mainCat = null)
{
    // Step 1: Filter categories by main_cat if given
    $categories = Category::when($mainCat, function ($query) use ($mainCat) {
        $query->where('main_cat', $mainCat);
    })->get();

    // Step 2: Get category IDs that belong to the mainCat
    $categoryIds = $mainCat 
        ? $categories->pluck('id') 
        : Category::pluck('id'); // fallback to all if no mainCat

    // Step 3: Listings base query
    $query = Listing::query()
        ->where('is_sold', false)
        ->whereIn('category_id', $categoryIds); // 👈 restrict by main_cat

    // Step 4: Filters
    if ($request->filled('category')) {
        $query->where('category_id', $request->category);
    }

    if ($request->filled('province')) {
        $query->where('province', $request->province);
    }

    if ($request->filled('city')) {
        $query->where('city', $request->city);
    }

    if ($request->filled('breed')) {
        $query->where('breed_id', $request->breed);
    }

    if ($request->sort_price === 'high') {
        $query->orderByRaw('(CASE WHEN total_price IS NOT NULL THEN total_price ELSE price END) DESC');
    } elseif ($request->sort_price === 'low') {
        $query->orderByRaw('(CASE WHEN total_price IS NOT NULL THEN total_price ELSE price END) ASC');
    }

    $listings = $query->get();

    // Supporting data
    $provinces = Listing::select('province')->distinct()->pluck('province')->filter();
    $cities = Listing::select('city')->distinct()->pluck('city')->filter();
    $breeds = Breed::whereIn('id', Listing::distinct()->pluck('breed_id')->filter())->get();

    $likedListingIds = [];
    if (Auth::guard('phoneUser')->check()) {
        $likedListingIds = ListingLike::where('phone_user_id', Auth::guard('phoneUser')->id())
            ->pluck('listing_id')
            ->toArray();
    }

    return view($viewName, compact(
        'listings',
        'categories',
        'provinces',
        'cities',
        'breeds',
        'likedListingIds',
        'mainCat'
    ));
}


    
    
    public function showForm()
    {
        $provinces = Province::with('cities')->get(); // Load provinces with their cities
        return view('postlisting', compact('provinces'));
    }
    public function showPostForm()
    {
        $provinces = Province::all(); // get all province names
        return view('postads', compact('provinces'));
    }
    public function showCounts($id)
    {
        $listing = Listing::with('interaction')->findOrFail($id);
        
        $interaction = ListingInteraction::firstOrCreate(['listing_id' => $id]);
        $interaction->increment('view_count');
        
        return view('listing.show', compact('listing'));
    }
    
    public function deleteOld()
    {
        $deleted = \App\Models\Listing::where('updated_at', '<', now()->subDays(30))->delete();
    
        return response()->json([
            'message' => "$deleted old listing(s) deleted successfully."
        ]);
    }
    
    public function markAsSold($id)
    {
        $listing = Listing::findOrFail($id);
        $listing->is_sold = true;
        $listing->save();
    
        return redirect()->back()->with('success', 'جانور کو کامیابی سے فروخت شدہ مارک کر دیا گیا۔');
    }
    public function destroy2($id)
    {
        $listing = Listing::findOrFail($id);
        $listing->delete();
    
        return redirect()->route('phone-user.posted-ads')->with('success', 'Listing deleted successfully.');
    }
    
    public function userListings($id)
    {
        $user = \App\Models\PhoneUser::findOrFail($id); // or User:: if using default User model
    
        $listings = $user->listings()->latest()->paginate(12); // assuming relation defined
    
        return view('userlisting', compact('user', 'listings'));
    }




}