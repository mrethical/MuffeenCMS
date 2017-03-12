<?php

namespace App\Http\Controllers;

use App\Models\Repositories\MenusRepositoryInterface;
use App\Models\Repositories\PostsRepositoryInterface;
use App\Services\MenuService;

class PagesController extends Controller
{

    /**
     * @var PostsRepositoryInterface
     */
    private $_posts;

    private $_menus;

    public function __construct(
        MenusRepositoryInterface $menus,
        PostsRepositoryInterface $posts
    ) {
        $this->_menus = MenuService::getMenus($menus);
        $this->_posts = $posts;
    }

    public function home()
    {
        $title = config('app.name');
        $menus = $this->_menus;
        return view('pages.home', compact('title', 'menus'));
    }

    public function post($slug)
    {
        $post = $this->_posts->getBySlug($slug);
        $title = $post->title . ' | ' . config('app.name');
        $menus = $this->_menus;
        return view('pages.home', compact('title', 'menus'));
    }

}
