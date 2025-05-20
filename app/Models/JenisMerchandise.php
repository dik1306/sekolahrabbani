<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisMerchandise extends Model
{
    use HasFactory;
    protected $table = 'm_jenis_merchandise';
    protected $primaryKey = 'id';

    protected $fillable = [
        'jenis',
        'status',
    ];

    public function merchandise()
    {
        return $this->hasOne(Merchandise::class, 'jenis_id', 'id');
    }
}
