<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class services extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function file()
    {
        return $this->hasOne(services::class,'service_id', 'id');
    }
}
