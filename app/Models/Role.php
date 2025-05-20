<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $table = 'role';
    protected $primaryKey = 'id';

    public function user()
    {
        return $this->hasMany(User::class, 'id_role', 'id');
    }

    public function role_menus()
    {
        return $this->hasMany(RoleMenu::class, 'id_role', 'id');
    }

    public static function get_all()
    {
        $data = static::select('id', 'name', 'created_at', 'updated_at')
            ->get();

        return $data;
    }

    public static function get_by_id($id)
    {
        $data = static::with(['role_menus'])
            ->select('id', 'name', 'created_at', 'updated_at')
            ->where('id', $id)
            ->first();

        return $data;
    }

    public static function create_data($name)
    {
        $new_id = static::orderby('id', 'desc')->first() == null ? 1 : static::orderby('id', 'desc')->first()->id + 1;
        $data = static::create([
            'id' => $new_id,
            'name' => $name,
        ]);

        return $data;
    }

    public static function update_data($id, $name)
    {
        $data_update = [
            'name' => $name,
        ];

        $data = static::where('id', $id)
            ->update($data_update);

        return $data;
    }

}
