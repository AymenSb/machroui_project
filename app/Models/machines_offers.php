<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class machines_offers extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_name', 'client_surname', 'client_email','client_offer','client_number','machine_id','Accpted'
    ];
    public function machine(){
        return $this->BelongsTo(machines::class,'machine_id');
    }
}
