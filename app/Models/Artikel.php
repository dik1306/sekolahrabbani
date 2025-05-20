<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    use HasFactory;
    protected $table = 't_artikel';
    protected $primaryKey = 'id';

    protected $fillable = [
        'image',
        'judul',
        'isi_artikel',
        'status',
        'upload_by'
    ];
}
