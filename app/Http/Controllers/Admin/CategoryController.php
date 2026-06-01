<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller {
    public function index(Request $request)
    {
        $query = Category::query();
    
        // Apply Date Filter if Selected
        if ($request->has('date') && $request->date != null) {
            $query->whereDate('created_at', $request->date)
                  ->orWhereDate('updated_at', $request->date);
        }
    
        $categories = $query->latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }


    public function create() {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
    $request->validate([
        'name' => 'required|string|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        'main_cat' => 'required|string',
    ]);

    $category = new Category();
    $category->name = $request->name;
    $category->main_cat = $request->main_cat;

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('categories', 'public');
        $category->image = $imagePath;
    }

    $category->save();

    return redirect()->route('admin.categories.index')->with('success', 'Category added successfully!');
}


    public function edit(Category $category) {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'main_cat' => 'required|string|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
    ]);

    $category->name = $request->name;
    $category->main_cat = $request->main_cat;

    if ($request->hasFile('image')) {
        // Delete old image if exists
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        // Store new image
        $imagePath = $request->file('image')->store('categories', 'public');
        $category->image = $imagePath;
    }

    $category->save();

    return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully!');
}



    public function destroy(Category $category)
    {
        // Check if the category has any listings
        $listingCount = $category->listings()->count();
    
        if ($listingCount > 0) {
            return back()->with('warning', "This category has $listingCount associated listings. Deleting it will remove all related listings as well. Are you sure?");
        }
    
        // If no listings, delete the category
        $category->delete();
        
        return back()->with('success', 'Category deleted successfully.');
    }
    
    // public function adminDashboard() {
    //     $categories = Category::all(); // Fetch all categories
    //     return view('admin.dashboard', compact('categories'));
    // }
    
    public function scopeBirds($query)
    {
        return $query->where('main_cat', 'bird');
    }
    
    public function scopePets($query)
    {
        return $query->where('main_cat', 'pet');
    }
    
    public function scopeLivestock($query)
    {
        return $query->where('main_cat', 'livestock');
    }

}
