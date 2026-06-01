<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListingLike extends Model
{
    protected $table = 'listing_likes';

    protected $fillable = [
        'phone_user_id',
        'listing_id',
    ];

    public $timestamps = true;

    // Add the relationship to PhoneUser
    public function user()
    {
        return $this->belongsTo(PhoneUser::class, 'phone_user_id');
    }

    // Add the relationship to Listing (assuming you have a Listing model)
    public function listing()
    {
        return $this->belongsTo(Listing::class, 'listing_id');
    }
    
}
