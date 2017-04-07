<?php

namespace App\Services;

class Menus
{

    protected static $menu_groups = [
        1 => 'Public'
    ];

    public static function getGroups()
    {
        return self::$menu_groups;
    }

}