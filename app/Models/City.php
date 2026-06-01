<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $table = 'Cities'; // also case-sensitive

    protected $fillable = ['name', 'province_id', 'countryCode'];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }
}
