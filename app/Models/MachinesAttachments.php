<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachinesAttachments extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $casts = [
        'file_name' => 'array',
        'base64Url' => 'array',
        ];
}
