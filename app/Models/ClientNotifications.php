<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientNotifications extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'subtitle',
        'image',
        'link',
        'new',
        'client_id',
        'machine_id'
    ];

    public function User(){
        return $this->BelongsTo(User::class,'user_id');
    }
}
