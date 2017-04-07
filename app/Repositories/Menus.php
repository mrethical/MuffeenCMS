<?php

namespace App\Repositories;

use App\Models\Menu;

class Menus
{

    public static function getByGroupID($group_id)
    {
        return Menu::select(['id', 'name', 'url'])
            ->with(array('order' => function($query){
                $query->select('menu_id', 'parent_menu_id', 'order')
                    ->orderBy('parent_menu_id', 'desc')
                    ->orderBy('order', 'desc');
            }))
            ->get();
    }

    public static function getCount()
    {
        return Post::count();
    }

}