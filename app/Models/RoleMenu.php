<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleMenu extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'role_menus';

    protected $fillable = [
        'id_role',
        'id_menu',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role', 'id')->select('id', 'name');
    }

    public static function get_by_id($id)
    {
        $data = static::where('id', $id)
            ->first();

        return $data;
    }

    public static function get_by_id_role($id_role)
    {
        $data = static::where('id_role', $id_role)
            ->get();

        return $data;
    }

    public static function create_data($id_role, $id_menu)
    {
        $new_id = static::orderby('id', 'desc')->first() == null ? 1 : static::orderby('id', 'desc')->first()->id + 1;
        $data = static::create([
            'id_role' => $id_role,
            'id_menu' => $id_menu,
        ]);

        return $data;
    }

    public static function delete_by_id_role($id_role)
    {
        $data = static::where('id_role', $id_role)
            ->delete();

        return $data;
    }

}
