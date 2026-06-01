<?php

// App\Models\PhoneUser.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class PhoneUser extends Authenticatable
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'name', 'phone',
    ];

    public function listings()
    {
        return $this->belongsToMany(Listing::class, 'listing_user', 'user_id', 'listing_id');
    }
    public function listingLikes()
    {
        return $this->hasMany(ListingLike::class, 'phone_user_id');
    }
     public function likedListings()
    {
        return $this->belongsToMany(Listing::class, 'listing_likes', 'phone_user_id', 'listing_id');
    }
}
