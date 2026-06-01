<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cmf extends Model
{
    use HasFactory;
     protected $table = 'cmf';
    protected $fillable = ['fcm_token'];
}
