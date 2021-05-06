<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rawMaterials extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function file()
    {
        return $this->hasOne(rawmaterials_attachments::class,'formation_id', 'id');
    }

    public function subcategory()
    {
        return $this->belongsToMany(subcategory::class)->withTimestamps();
    }

    protected $casts = [
        'file_name' => 'array',
        ];
}
