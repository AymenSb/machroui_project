<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class machines extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'images' => 'array',
        'base64Urls' => 'array',
    ];

    public function offer()
    {
        return $this->hasOne(machines_offers::class, 'machine_id', 'id');
    }
    public function subcategory()
    {
        return $this->belongsToMany(subcategory::class)->withTimestamps();
    }

}
