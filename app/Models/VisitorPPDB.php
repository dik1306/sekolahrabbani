<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorPPDB extends Model
{
    use HasFactory;
    protected $table = 't_visitors_ppdb';
    protected $primaryKey = 'id';

    protected $fillable = [
        'ip_address',
        'user_agent',
        'location',
        'created_at'
    ];
}
