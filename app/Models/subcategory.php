<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subcategory extends Model
{
    use HasFactory;
    protected $guarded=[];


    public function formations()
    {
        return $this->belongsToMany(formations::class);
    }

    public function machines()
    {
        return $this->belongsToMany(machines::class);
    }

    public function materials()
    {
        return $this->belongsToMany(rawMaterials::class);
    }
    public function projects()
    {
        return $this->belongsToMany(project::class);
    }
  
}
