<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateDesain extends Model
{
    use HasFactory;
    protected $table = 'm_template_desain';
    protected $primaryKey = 'id';

    protected $fillable = [
        'jenis_id',
        'judul',
        'image_1'
    ];
}
