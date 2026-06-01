<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PhoneUser;
use App\Models\Listing;

class FeaturedRequest extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'listing_id', 'receipt_image', 'status', 'rupes', 'days'];

    public function user()
    {
        return $this->belongsTo(PhoneUser::class, 'user_id');
    }

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }
}
