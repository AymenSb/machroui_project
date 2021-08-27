<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestedMachines extends Model
{
    use HasFactory;
    protected $casts = [
        'images' => 'array',
        'base64Urls' => 'array',
    ];
    protected $fillable = [
        'name',
        'price',
        'Vendor',
        'vendor_id',
        'details',
        'characteristics',
        'markDetails',
        'state',
        'stateVal',
        'main_image',
        'images',
        'base64Urls',
        'video_name',
        'video_base64'

    ];

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vebdir_id', 'id');
    }
}
