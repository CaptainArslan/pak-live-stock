<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PhoneUserAuthController;
use App\Http\Controllers\Api\ListingApiController;
use App\Http\Controllers\Api\InformationApiController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\ListingInteractionController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\CmfController;
use App\Http\Controllers\Api\PhoneUserLikeController;

use App\Http\Controllers\Api\ListController;

// Public route for login


Route::get('/server-limits', function() {
    return [
        'post_max_size' => ini_get('post_max_size'),
        'upload_max_filesize' => ini_get('upload_max_filesize'),
        'memory_limit' => ini_get('memory_limit'),
    ];
});  


Route::post('/add_list', [ListController::class, 'store']);
Route::post('/listings/{listing}/images', [ListController::class, 'uploadImages']);

Route::put('/update_listing/{id}', [ListController::class, 'updateListingById']);
Route::post('/update_listing/{id}/images', [ListController::class, 'updateListingImages']);

Route::get('/listings/{id}/featured', [ListController::class, 'getFeaturedListings']);



Route::post('/register', [PhoneUserAuthController::class, 'register']);
Route::post('/login', [PhoneUserAuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [PhoneUserAuthController::class, 'user']);
    Route::post('/logout', [PhoneUserAuthController::class, 'logout']);
});
Route::get('/users', [PhoneUserAuthController::class, 'user']);
Route::get('/user/{user_id}/listings', [PhoneUserAuthController::class, 'postedAds']);




    Route::post('/listing/store-text', [ListingApiController::class, 'storeTextFields']);
    Route::post('/listing/{id}/upload-images', [ListingApiController::class, 'uploadImages']);
    // Use api.php if this is an API request
    Route::post('/listing/{id}/upload-images', [ListingApiController::class, 'uploadImages']);



    Route::get('/listings', [ListingApiController::class, 'index']);
    Route::post('/listings/{category_id}', [ListingApiController::class, 'index']);
// Route::middleware('auth:phoneUser')->group(function () {
    Route::post('/listings', [ListingApiController::class, 'store']);
    Route::post('/update-listing/{id}', [ListingApiController::class, 'updateListingById']);

// });


Route::get('/categories', [\App\Http\Controllers\Api\CategoryApiController::class, 'index']);
Route::get('/breeds', [\App\Http\Controllers\Api\BreedApiController::class, 'index']);



Route::get('/informations', [InformationApiController::class, 'index']);
Route::get('/informations/{id}', [InformationApiController::class, 'show']);

Route::get('/test', function () {
    return response()->json(['message' => 'API is working!']);
});

Route::get('/test', function () {
    return response()->json(['message' => 'API is working!']);
});

// location -> province and cities 
Route::get('/provinces', [LocationController::class, 'getProvinces']);
Route::get('/cities', [LocationController::class, 'getCities']);
Route::get('/cities/{province_id}', [LocationController::class, 'getCitiesByProvince']);


// for user 

    Route::get('/user-profile/{id}', [PhoneUserAuthController::class, 'getProfileById']);
// routes/api.php
    Route::post('/phone-user/{id}', [PhoneUserAuthController::class, 'updateProfileById']);



// For recording view, contact click, and share click count
Route::post('/listing/{id}/view', [ListingInteractionController::class, 'viewCount']);
Route::post('/listing/{id}/contact-click', [ListingInteractionController::class, 'contactClick']);
Route::post('/listing/{id}/share-click', [ListingInteractionController::class, 'shareClick']);
// cmf 
Route::post('/cmf', [CmfController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/listings/{id}/like', [ListingApiController::class, 'toggleLike']);
});

// liking posts 
Route::get('/user/{user_id}/liked-listings', [PhoneUserLikeController::class, 'likedListingsById']);
Route::post('/user/like-listing', [PhoneUserLikeController::class, 'likeListing']);
Route::post('/user/unlike-listing', [PhoneUserLikeController::class, 'unlikeListing']);

// Sold 
Route::post('/listings/{id}/mark-sold', [ListingApiController::class, 'markAsSold']);

// delete listing 
Route::delete('/listings/{id}', [ListingApiController::class, 'destroy']);



