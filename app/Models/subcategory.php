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

    public function machines()
    {
        return $this->belongsToMany(machines::class)->withTimestamps();
    }

    public function materials()
    {
        return $this->belongsToMany(rawMaterials::class)->withTimestamps();
    }
  
}
