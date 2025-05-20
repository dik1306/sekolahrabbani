<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrialClass extends Model
{
    use HasFactory;
    protected $table = 't_trial_class';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nama_anak',
        'usia_anak',
        'tgl_lahir',
        'tujuan_sekolah',
        'jenjang_id',
        'no_wa',
        'asal_sekolah',
        'tahun_ajaran'
    ];
}
