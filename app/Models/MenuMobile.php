<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuMobile extends Model
{
    use HasFactory;
    protected $table = 'menus_mobile';
    protected $primaryKey = 'id';

}
