<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class formations extends Model
{
    use HasFactory;
    protected $guarded=[];
    
    public function file()
    {
        return $this->hasOne(formations_attachment::class,'formation_id', 'id');
    }
}
