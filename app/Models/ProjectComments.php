<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectComments extends Model
{
    use HasFactory;
    protected $fillable=[
        'client_id',
        'comment',
        'project_id',
        'isShown'
    ];
    public function UserComment(){
        return $this->hasOne(User::class,'id','client_id');
    }
}
