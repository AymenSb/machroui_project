<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class services extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $casts = [
        'images' => 'array',
        'base64Urls' => 'array',
        ];

    
}
