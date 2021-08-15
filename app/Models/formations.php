<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class formations extends Model
{
    use HasFactory;
    protected $fillable=[
        "name","begin_date","places","participants","description","trainer","locale","plan","link",
        "price",""
    ];
    
    public function file()
    {
        return $this->hasOne(formations_attachment::class,'formation_id', 'id');
    }

    public function request(){
        return $this->hasOne(formations_requests::class,'formation_id','id');
    }
    public function subcategory()
    {
        return $this->belongsToMany(subcategory::class);
    }
}
