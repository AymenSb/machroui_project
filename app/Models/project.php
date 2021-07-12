<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class project extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'images' => 'array',
        'base64Urls' => 'array',
        ];
   

        public function subcategory()
    {
        return $this->belongsToMany(subcategory::class)->withTimestamps();
    }
}

