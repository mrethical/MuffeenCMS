<?php

namespace App\Repositories;

use App\Models\Menu;

class Menus
{

    public static function getByGroupID($group_id)
    {
        return Menu::select(['id', 'name', 'url', 'parent_id'])
            ->with(array('order' => function($query){
                $query->select('menu_id', 'order');
            }))
            ->where('menu_group_id', '=', $group_id)
            ->get();
    }

    public static function getRootByGroupID($group_id)
    {
        return Menu::select(['id', 'name', 'url', 'parent_id'])
            ->whereNull('parent_id')
            ->where('menu_group_id', '=', $group_id)
            ->get();
    }

    public static function getCount()
    {
        return Post::count();
    }

}