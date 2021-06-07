<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rawMaterials extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $casts = [
        'images' => 'array',
        'base64Urls'=>'array',
        ];

    public function file()
    {
        return $this->hasOne(rawmaterials_attachments::class,'rawmaterial_id', 'id');
    }

    public function request(){
        return $this->hasOne(rawmaterials_requests::class,'rawmaterial_id','id');
    }

    public function subcategory()
    {
        return $this->belongsToMany(subcategory::class)->withTimestamps();
    }

}
