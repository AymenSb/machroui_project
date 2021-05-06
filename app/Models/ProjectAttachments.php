<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectAttachments extends Model
{
    use HasFactory;
    protected $fillable=[ 
        'file_name',
        'project_id',
    ];
    protected $casts = [
        'file_name' => 'array',
        ];

}
