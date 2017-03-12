<?php

namespace App\Http\Controllers;

use App\Models\Repositories\MenusRepositoryInterface;
use App\Models\Repositories\PostsRepositoryInterface;

class PagesController extends Controller
{

    /**
     * @var MenusRepositoryInterface
     */
    private $_menus;

    /**
     * @var PostsRepositoryInterface
     */
    private $_posts;

    public function __construct(
        MenusRepositoryInterface $menus,
        PostsRepositoryInterface $posts
    ) {
        $this->_menus = $menus;
        $this->_posts = $posts;
    }

    public function home()
    {
        $title = config('app.name');
        $menus = $this->getMenus();
        return view('pages.home', compact('title', 'menus'));
    }

    public function post($slug)
    {
        $post = $this->_posts->getBySlug($slug);
        $title = $post->title . ' | ' . config('app.name');
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
