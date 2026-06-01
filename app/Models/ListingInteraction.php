<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListingInteraction extends Model
{
    use HasFactory;
    
    protected $table = 'listing_interaction';

    protected $fillable = [
        'listing_id',
        'view_count',
        'contact_clicks',
        'share_clicks'
    ];

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }

}
