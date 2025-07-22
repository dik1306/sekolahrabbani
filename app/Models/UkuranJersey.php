<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UkuranJersey extends Model
{
    use HasFactory;
    
    protected $table = 'm_ukuran_jersey';  // Nama tabel di database
    protected $primaryKey = 'id';  // Primary key jika bukan id

    public function ukuranSeragam()
    {
        return $this->hasOne(UkuranSeragam::class, 'ukuran_seragam', 'ukuran_jersey');  // Relasi dengan UkuranSeragam
    }
}
