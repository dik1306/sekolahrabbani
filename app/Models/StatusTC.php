<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusTC extends Model
{
    use HasFactory;
    protected $table = 'm_status_trial_class';
    protected $primaryKey = 'id';

    public static function get_status_tc () {
        $data = static::where('stat', 1)
            ->get();

        return $data;
    }
}
