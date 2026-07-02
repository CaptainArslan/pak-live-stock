<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ListingController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BreedController;
use App\Models\Category;
use App\Models\Breed;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PhoneUserController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\InformationController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\FeaturedRequestController;
use App\Http\Controllers\Admin\FeaturedRequestController as AdminFeaturedRequestController;
use App\Http\Controllers\FirebaseAuthController;
use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\City;
use App\Http\Controllers\ListingIntractionController;
use App\Http\Controllers\ListingLikeController;
use App\Models\Information;
use Illuminate\Support\Facades\Storage;

// Serve uploaded files from storage/app/public without requiring public/storage symlink.
Route::get('/storage/app/public/{path}', function (string $path) {
    $path = str_replace(['..', '\\'], '', $path);

    if (! Storage::disk('public')->exists($path)) {
        abort(404);
    }

    return Storage::disk('public')->response($path);
})->where('path', '.*');

Route::get('/clear-all', function () {
    \Artisan::call('config:clear');
    \Artisan::call('view:clear');
    return 'Cleared config & view cache';
});

Route::post('/firebase-login', [AuthController::class, 'firebaseLogin']);



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::patch('/listings/{id}/mark-as-sold', [ListingController::class, 'markAsSold'])->name('listings.markAsSold');


Route::post('/ask-ai', [App\Http\Controllers\AIChatController::class, 'askAI']);


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('admin/breeds/check-exists', [BreedController::class, 'checkBreedExists'])->name('admin.breeds.check');

// for feature ads
Route::post('/firebase-login', [FirebaseAuthController::class, 'firebaseLogin'])->name('firebase-login');


Route::middleware(['RedirectUser'])->group(function () {
    Route::get('/featured/instructions/{listing_id}', [FeaturedRequestController::class, 'instructions'])->name('featured.instructions');
    Route::post('/featured/store', [FeaturedRequestController::class, 'store'])->name('featured.store');
});

// Admin Routes
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/featured-requests', [AdminFeaturedRequestController::class, 'index'])->name('admin.featured.index');
    Route::post('/featured-requests/approve/{id}', [AdminFeaturedRequestController::class, 'approve'])->name('admin.featured.approve');
    Route::post('/featured-requests/reject/{id}', [AdminFeaturedRequestController::class, 'reject'])->name('admin.featured.reject');
});
Route::get('/get-cities-by-province', [App\Http\Controllers\LocationController::class, 'getCitiesByProvince'])->name('get.cities.by.province');


Route::get('/get-cities/{province}', function ($provinceName) {
    $cities = City::whereHas('province', function ($query) use ($provinceName) {
        $query->where('name', $provinceName);
    })->get(['name']);

    return response()->json($cities);
});

Route::get('/user-listings/{id}', [ListingController::class, 'userListings'])->name('userlisting');


//for Logout

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login'); // Redirect to login page after logout
})->name('logout')->middleware('auth');

Route::delete('/listing/{id}', [ListingController::class, 'destroy2'])->name('listing.destroy');



Route::get('/admin', [AdminController::class, 'dashboard'])->middleware(['auth'])->name('dashboard');
Route::get('/dashboard', [AdminController::class, 'dashboard'])->middleware(['auth'])->name('dashboard');


Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('listings', ListingController::class)->middleware('auth');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('categories', CategoryController::class)->middleware('auth');
});
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('breeds', BreedController::class)->middleware('auth');
});

Route::get('/admin/get-breeds', function (Request $request) {
    if (!$request->has('category')) {
        return response()->json(['error' => 'Category ID is required'], 400);
    }

    $breeds = Breed::whereHas('categories', function ($query) use ($request) {
        $query->where('categories.id', $request->category);
    })->get();

    return response()->json($breeds);
});

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::resource('phone-users', PhoneUserController::class);
});

//information routes

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::resource('informations', InformationController::class);
});



Route::get('/info', [InformationController::class, 'infoIndex'])->name('info.index');

Route::get('/info/{id}', function ($id) {
    $info = Information::findOrFail($id);
    $recentInfos = Information::where('id', '!=', $id)
        ->orderBy('updated_at', 'desc')
        ->take(5)
        ->get();

    return view('info.show', compact('info', 'recentInfos'));
})->name('info.show');



//forpostads page
Route::get('/postads', function () {
    $categories = Category::all();
    $breeds = Breed::whereHas('categories')->get();
    $provinces = Province::all()->sortBy('name', SORT_LOCALE_STRING);


    return view('postads', compact('categories', 'breeds', 'provinces'));
})->middleware('RedirectUser')->name('postads');


Route::get('/petpostads', function () {
    $categories = Category::all();
    $breeds = Breed::whereHas('categories')->get();
    $provinces = Province::all()->sortBy('name', SORT_LOCALE_STRING);

    return view('petpostads', compact('categories', 'breeds', 'provinces'));
})->middleware('RedirectUser')->name('petpostads');

Route::get('/birdpostads', function () {
    $categories = Category::all();
    $breeds = Breed::whereHas('categories')->get();
    $provinces = Province::all()->sortBy('name', SORT_LOCALE_STRING);

    return view('birdpostads', compact('categories', 'breeds', 'provinces'));
})->middleware('RedirectUser')->name('birdpostads');

Route::get('/otherpostads', function () {
    $categories = Category::all();
    $breeds = Breed::whereHas('categories')->get();
    $provinces = Province::all()->sortBy('name', SORT_LOCALE_STRING);

    return view('otherpostads', compact('categories', 'breeds', 'provinces'));
})->middleware('RedirectUser')->name('otherpostads');

// Store listings from user side (same table as admin)
Route::post('/postlisting', [ListingController::class, 'store'])->name('postlisting');



// Fetch breeds based on category ID (AJAX)
Route::get('/breeds/by-category/{category_id}', [ListingController::class, 'getBreedsByCategory']);
// Route::get('/breeds/by-category/{id}', function ($id) {
//     $breeds = Breed::where('category_id', $id)->get(['id', 'name']);
//     return response()->json($breeds);
// });



//for the single ad page
Route::get('/listing/{id}', [ListingController::class, 'show'])->name('listing.show');
Route::post('/listings/delete-old', [ListingController::class, 'deleteOld'])->name('listings.delete.old');
//thankYou Page
Route::get('/thank', function () {
    return view('thank');
})->name('thank');

Route::get('/preform', function () {
    return view('preform');
})->name('preform');

// services
Route::get('/services', function () {
    return view('services');
})->name('services');



// ✅ Registration & Login Route
Route::get('/register-user', function () {
    return view('auth.phone_register'); // Make sure this Blade file exists
})->name('phone.register');

// ✅ Handle user registration/login via POST
Route::post('/register-user', [PhoneUserController::class, 'registerOrLogin'])->name('register-user');
Route::post('/register-firebase-user', [FirebaseAuthController::class, 'registerFirebaseUser']);

// ✅ User Dashboard (Protected Route)
Route::middleware('RedirectUser')->group(function () {
    Route::get('/phone-user/dashboard', [PhoneUserController::class, 'dashboard'])->name('phone-user.dashboard');
    Route::get('/phone-user/profile', [PhoneUserController::class, 'profile'])->name('phone-user.profile');
    Route::post('/phone-user/updateProfile', [PhoneUserController::class, 'updateProfile'])->name('phone-user.updateProfile');
    Route::get('/phone-user/posted-ads', [PhoneUserController::class, 'postedAds'])->name('phone-user.posted-ads');
    Route::get('/phone-user/notifications', [FeaturedRequestController::class, 'notifications'])->name('phone-user.notifications');
    Route::get('/phone-user/likedAds', [PhoneUserController::class, 'likedAds'])->name('phone-user.likedAds');
    Route::post('/phone-user/logout', [PhoneUserController::class, 'logout'])->name('phone-user.logout');
    Route::get('/phone-user/edit/{listing}', [ListingController::class, 'editByUser'])->name('phone-user.edit');
    Route::get('/phone-user/other-edit/{listing}', [ListingController::class, 'editByUser'])->name('phone-user.other-edit');
    Route::get('/phone-user/bird-edit/{listing}', [ListingController::class, 'editByUser'])->name('phone-user.bird-edit');
    Route::get('/phone-user/pet-edit/{listing}', [ListingController::class, 'editByUser'])->name('phone-user.pet-edit');
    Route::put('/phone-user/edit/{listing}', [ListingController::class, 'updateByUser'])->name('phone-user.updateByUser');
});


Route::get('/listingFront', [ListingController::class, 'listingFront'])->name('listingFront');
Route::get('/petlistingFront', [ListingController::class, 'petListingFront'])->name('petlistingFront');
Route::get('/birdlistingFront', [ListingController::class, 'birdListingFront'])->name('birdListingFront');
Route::get('/otherlistingFront', [ListingController::class, 'otherListingFront'])->name('otherListingFront');




Route::get('/allCategories', [ListingController::class, 'listingFront'])->name('allcategory');

// for api's


Route::post('/phone-user/login', [PhoneUserController::class, 'apiLoginOrRegister']);


Route::post('/listing-interaction', [ListingInteractionController::class, 'store']);
Route::middleware('auth:phoneUser')->group(function () {
    Route::post('/listing/{id}/contact-click', [ListingIntractionController::class, 'contactClick']);
    Route::post('/listing/{id}/share-click', [ListingIntractionController::class, 'shareClick']);
    Route::post('/listing/{id}/view', [ListingIntractionController::class, 'countView']);
});

// listing like

Route::post('/listing/like', [ListingLikeController::class, 'toggle']);

Route::get('/user/{id}/liked-listings', [ListingLikeController::class, 'getUserLikedListings']);

Route::get('/privacy-policy', function () {
    return view('privacyPolicy');
})->name('privacyPolicy');


require __DIR__ . '/auth.php';
