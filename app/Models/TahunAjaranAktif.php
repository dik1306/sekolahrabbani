<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAjaranAktif extends Model
{
    use HasFactory;
    protected $table = 'master_tahun_ajaran';
    protected $primaryKey = 'id';
}
