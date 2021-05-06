<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class project extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function file()
    {
        return $this->hasOne(ProjectAttachments::class,'machine_id','id');
    }

    protected $casts = [
        'file_name' => 'array',
        ];
}

