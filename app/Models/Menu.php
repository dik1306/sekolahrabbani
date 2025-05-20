<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $table = 'menus';

    protected $fillable = [
        'name',
        'url',
        'icon',
        'root',
        'no',
        'created_at'
    ];

    public function parent()
    {
        return $this->hasOne('App\Models\Menu', 'id_menu', 'root');
    }

    public function children()
    {
        return $this->hasMany('App\Models\Menu', 'root', 'id_menu');
    }

    public function sub()
    {
        return $this->hasMany('App\Models\Menu', 'root', 'id_menu')
            ->join('role_menus', 'menus.id', '=', 'role_menus.id_menu')
            ->where('role_menus.id_role', auth()->user()->id_role)
            ->select('menus.*', 'id_menu', 'id_role')
            ->groupby('menus.id', 'menus.name', 'menus.url', 'menus.icon', 'menus.root', 'role_menus.id_menu', 'role_menus.id_role', 'menus.no');
    }

    public function submenu()
    {
        return $this->hasMany(Menu::class, 'root', 'id')->orderby('no', 'asc');
    }

    public static function tree($idRole)
    {
        $menus = static::with(implode('.', array_fill(0, 100, 'sub')))
            ->join('role_menus', 'role_menus.id_menu', 'menus.id')
            ->where('root', '=', '0')
            ->where('role_menus.id_role', $idRole)
            ->get()
            ->makeHidden(['id_role']);

        return $menus;
    }

    public static function get_menu_by_id_role($idRole)
    {
        $menus = static::with(implode('.', array_fill(0, 100, 'sub')))
            ->join('role_menus', 'role_menus.id_menu', 'menus.id')
            ->where('root', '=', '0')
            ->where('role_menus.id_role', $idRole)
            ->orderby('no', 'asc')
            ->get();

        // dd($menus);

        return $menus;
    }

    public static function get_all()
    {
        $menus = static::with(implode('.', array_fill(0, 100, 'submenu')))
            ->where('root', '=', '0')
            ->orderby('no', 'asc')
            ->get();

        return $menus;
    }

}
