<?php

use App\Models\Menu;
use App\Models\User;

if (!function_exists('getMenus')) {
    function getMenus()
    {
        return Menu::get_menu_by_id_role(auth()->user()->id_role);
    }
}
