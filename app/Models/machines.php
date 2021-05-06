<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class machines extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function file()
    {
        return $this->hasOne(MachinesAttachments::class,'machine_id','id');
    }

    public function subcategory()
    {
        return $this->belongsToMany(subcategory::class)->withTimestamps();
    }

    protected $casts = [
        'file_name' => 'array',
        ];

}
