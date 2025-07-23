<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JerseyImage extends Model
{
    use HasFactory;
    protected $table = 'm_jersey_images';

    // Menonaktifkan pengelolaan timestamp
    public $timestamps = false;

    protected $fillable = [
        'jersey_id',
        'image_url',
        'isSizeChart'
    ];
}

