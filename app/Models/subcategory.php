<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subcategory extends Model
{
    use HasFactory;

    public function formations()
    {
        return $this->belongsToMany(formations::class)->withTimestamps();
    }
  
}
