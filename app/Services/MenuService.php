<?php

namespace App\Services;

use App\Models\Repositories\MenusRepositoryInterface;

class MenuService
{

    public static function getMenus(MenusRepositoryInterface $menus)
    {
        $parents = $menus->getAllNoParent();
        $menus = [];
        if ($parents) {
            foreach ($parents->all() as $parent) {
                $menus[$parent->name] = [
                    'link' => url(($parent->post) ? $parent->post->slug : '#'),
                    'children' => []
                ];
                $children = $parent->children;
                if ($children) {
                    foreach ($children as $child) {
                        $menus[$parent->name]['children'][$child->name] = [
                            'link' => url(($child->post) ? $child->post->slug : '#'),
                        ];
                    }
                }
            }
        }
        return $menus;
    }
}