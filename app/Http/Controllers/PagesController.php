<?php

namespace App\Http\Controllers;

use App\Models\Repositories\MenusRepositoryInterface;

class PagesController extends Controller
{

    /**
     * @var MenusRepositoryInterface
     */
    private $_menus;

    public function __construct(MenusRepositoryInterface $menus)
    {
        $this->_menus = $menus;
    }

    public function home()
    {
        $title = config('app.name');
        $menus = $this->getMenus();
        return view('pages.home', compact('title', 'menus'));
    }

    private function getMenus()
    {
        $parents = $this->_menus->getAllNoParent();
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
