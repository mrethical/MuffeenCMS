<?php

namespace App\Http\Controllers;

class PagesController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function posts()
    {
        $page = request('page', 1);
        if (!is_numeric($page)) {
            $page = 1;
        }
        $posts = \App\Repositories\Posts::getMostRecent(10, ($page-1)*10);
        $count = \App\Repositories\Posts::getCount();
        $title = 'All Blog Posts | ' . config('app.name');
        $header = 'All Blog Posts';
        $page_url = '/posts';
        return view('posts.list', compact('page', 'posts', 'count', 'title', 'header', 'page_url'));
    }

    public function post($slug)
    {
        $post = \App\Models\Post::where('slug', '=', $slug)->first();
        $uploads_url = \App\Services\Uploads::getUploadUrls()['upload'];
        $title = $post->title . ' - Blog Post | ' . config('app.name');

        return view('posts.index', compact('post', 'uploads_url', 'title'));
    }

}
