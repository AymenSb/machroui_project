<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rawmaterials_requests extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_name', 'client_surname', 'client_email', 'client_number','rawmaterial_id','unavailable',
        'available','quantity','message','client_id'
    ];
    public function material(){
        return $this->BelongsTo(rawMaterials::class,'rawmaterial_id');
    }
}
