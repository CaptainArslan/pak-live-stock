<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'title', 'category_id', 'breed_id', 'gaban', 'suwa', 'quantity',
        'age_years', 'age_months', 'min_age_years', 'min_age_months', 'max_age_years', 'max_age_months',
        'total_price', 'price_per_animal', 'price_per_kg', 'price',
        'milk_quantity', 'teeth', 'min_teeth', 'max_teeth',
        'weight', 'min_weight', 'max_weight', 'gender',
        'province', 'city', 'address', 'contact_number',
        'detail', 'is_featured', 'images', 
        'featured_until', 'is_sold', 
        'height', 'max_height', 'min_height', 'sath_janwar', 'rate_on_call',
        'verified', 'warrenty',
    ];
    
    protected $casts = [
        'images' => 'array', 
    ];

    /**
     * Relationship: Listing belongs to a Category.
     */
    public function category() {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relationship: Listing belongs to a Breed.
     */
    public function breed() {
        return $this->belongsTo(Breed::class);
    }

    public function users()
    {
        return $this->belongsToMany(PhoneUser::class, 'listing_user', 'listing_id', 'user_id');
    }
    public function interaction()
    {
        return $this->hasOne(ListingInteraction::class);
    }
    public function likedByUsers()
    {
        return $this->belongsToMany(PhoneUser::class, 'listing_likes');
    }
    
}
