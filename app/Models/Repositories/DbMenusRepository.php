<?php

namespace App\Models\Repositories;

use App\Models\Menu;

class DbMenusRepository implements MenusRepositoryInterface
{

    private $_menus;

    function __construct()
    {
        $this->_menus = new Menu();
    }

    public function getAll()
    {
        return Menu::all();
    }

    public function getCountAll()
    {
        return Menu::count();
    }

    public function getAllWithLimit($limit, $offset)
    {
        return Menu::take($limit)->offset($offset)->get();
    }

    public function getPairAll()
    {
        $menus = Menu::pluck('name', 'id');
        $list = array();
        foreach ($menus as $id=>$name) {
            $list[$id] = $name;
        }
        return $list;
    }

    public function getAllNoParent()
    {
        return Menu::whereNull('parent_id')->get();
    }

    public function getParentByID($id)
    {
        $menu = Menu::where('id', $id)->first();
        return $menu->parent;
    }

    private function _getFamily($id)
    {
        $not_possible_parent = [$id];
        $children = $this->_menus->where('parent_id', $id)->get();
        foreach ($children as $child)
        {
            $not_possible_parent = array_merge($not_possible_parent, $this->_getFamily($child->id));
        }
        return $not_possible_parent;
    }

    public function getPossibleParent($id)
    {
        return Menu::whereNotIn('id', $this->_getFamily($id))->get();
    }

}