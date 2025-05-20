<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Role;
use App\Models\RoleMenu;
use Exception;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function get_menu(Request $request)
    {
        try {
            $id_role = $request->get('role');

            if (!Role::get_by_id($id_role) != null) {
                return $this->error((object)NULL, 'role not found', 400);
            }

            $arr_menu = Menu::get_menu_by_id_role($id_role);

            $get_menu_by_role = app('App\Http\Controllers\Role\RoleController')->arrange_menu($arr_menu, $arr_menu, 0);
            $data = $get_menu_by_role;
            return $this->success($data, 'Berhasil', 200);
        } catch (Exception $e) {
            return $this->error([], $e->getMessage(), 400);
        }
    }
    public function get_all(Request $request)
    {
        try {
            $data = Menu::get_all();
            return $this->success($data, 'Berhasil', 200);
        } catch (Exception $e) {
            return $this->error([], $e->getMessage(), 400);
        }
    }

    public function list_menu() 
    {
        $data = Menu::all();

        $root = Menu::where('root', 0)->get();

        return view('admin.master.menu.index', compact('data', 'root'));
    }

    public function create_menu(Request $request)
    {
        try {
            $nama_menu = $request->nama_menu;
            $icon = $request->icon;
            $url = $request->url;
            $root = $request->root;

            
            $menu = Menu::where('root', $root)->orderby('no', 'Desc')->first();
            if ($menu == null) {
                $new_urutan = 1;
            } else {
                $last_urutan = $menu->no;
                $new_urutan = $last_urutan +1;
            }

            $add_menu = Menu::create([
                'name' => $nama_menu,
                'url' => $url,
                'icon' => $icon,
                'root' => $root,
                'no' => $new_urutan
            ]);

            $add_role_menu =  RoleMenu::create([
                'id_role' => 1,
                'id_menu' => $add_menu->id
            ]);

            return redirect()->route('master.menu')->with('success', 'Berhasil tambah menu');

        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function create_root(Request $request)
    {
        try {
            $name_root = $request->nama_root;
            $icon = $request->icon_root;

            
            $root = Menu::where('root', 0)->orderby('no', 'Desc')->first();
            $last_root = $root->no;
            $new_root = $last_root +1;

            $add_root = Menu::create([
                'name' => $name_root,
                'url' => '#',
                'icon' => $icon,
                'root' => 0,
                'no' => $new_root
            ]);

            $add_role_menu =  RoleMenu::create([
                'id_role' => 1,
                'id_menu' => $add_root->id
            ]);

            return redirect()->back();
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

}
