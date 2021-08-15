<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class formations_requests extends Model
{
    use HasFactory;

    protected $fillable = [
       'client_id','isComing', 'client_name', 'client_surname', 'client_email', 'client_number','formation_id','Accepted'
    ];
    public function formation(){
        return $this->BelongsTo(formations::class,'formation_id');
    }
}
