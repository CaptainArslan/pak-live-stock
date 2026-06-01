<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Breed;
use App\Models\Category;

class BreedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
   public function index(Request $request)
{
    $query = Breed::query();

    // Filter by date
    if ($request->has('date') && $request->date != null) {
        $query->whereDate('created_at', $request->date)
              ->orWhereDate('updated_at', $request->date);
    }

    // Filter by category
    if ($request->has('category') && $request->category != '') {
        $query->whereHas('categories', function ($q) use ($request) {
            $q->where('categories.id', $request->category);
        });
    }

    // Fetch results
    $breeds = $query->with('categories', 'listings')->get();

    // Sort breeds by their **lowest associated category ID**
    $sortedBreeds = $breeds->sortBy(function ($breed) {
        return $breed->categories->pluck('id')->min() ?? 9999;
    })->values(); // Reset index

    // Paginate manually
    $perPage = 10;
    $page = request()->get('page', 1);
    $paginated = new \Illuminate\Pagination\LengthAwarePaginator(
        $sortedBreeds->forPage($page, $perPage),
        $sortedBreeds->count(),
        $perPage,
        $page,
        ['path' => request()->url(), 'query' => request()->query()]
    );

    $categories = Category::all();

    return view('admin.breeds.index', [
        'breeds' => $paginated,
        'categories' => $categories,
    ]);
}




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.breeds.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:breeds,name',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id'
        ]);

        $breed = Breed::create([
            'name' => $request->name
        ]);

        $breed->categories()->attach($request->categories);

        return redirect()->route('admin.breeds.index')->with('success', 'Breed created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Breed $breed)
    {
        $categories = Category::all();
        return view('admin.breeds.edit', compact('breed', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Breed $breed)
    {
        $request->validate([
            'name' => 'required|string|unique:breeds,name,' . $breed->id,
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id'
        ]);

        $breed->update([
            'name' => $request->name
        ]);

        $breed->categories()->sync($request->categories);

        return redirect()->route('admin.breeds.index')->with('success', 'Breed updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    
    public function destroy(Breed $breed)
    {
        // Check if the breed has any associated listings
        $listingCount = $breed->listings()->count();
    
        if ($listingCount > 0) {
            return back()->with('warning', "This breed has $listingCount associated listings. Deleting it will remove all related listings as well. Are you sure?");
        }
    
        // Detach from categories (many-to-many relationship)
        $breed->categories()->detach();
    
        // Delete the breed
        $breed->delete();
    
        return back()->with('success', 'Breed deleted successfully.');
    }
    
    public function checkBreedExists(Request $request)
    {
        $breed = Breed::where('name', $request->name)->first();
    
        if ($breed) {
            $categoryIds = $breed->categories()->pluck('categories.id'); // Get associated category IDs
            return response()->json([
                'exists' => true,
                'category_ids' => $categoryIds
            ]);
        }
    
        return response()->json(['exists' => false]);
    }


}
