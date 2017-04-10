<?php

namespace App\Http\Controllers;

class PagesController extends Controller
{
    public function home()
    {
        $posts = \App\Repositories\Posts::getMostRecent(3);
        $title = config('app.name');

        return view('home', compact('posts', 'title'));
    }

    public function contact()
    {
        $title = 'Contact Us | ' . config('app.name');

        return view('contact', compact('title'));
    }

    public function contact_submit()
    {
        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        $inquiry = \App\Models\Inquiry::create([
            'name' => request('name'),
            'email' => request('email'),
            'subject' => request('subject'),
            'message' => request('message')
        ]);

        request()->session()->flash('saved', $inquiry->id);
        return redirect(url('/contact'));
    }

    public function page($slug)
    {
        $page = \App\Models\Page::where('slug', '=', $slug)->first();
        $title = $page->title . ' | ' . config('app.name');

        return view('pages.index', compact('page','title'));
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

    public function categories($slug)
    {
        if ($slug == 'uncategorized') {
            $category = new \stdClass;
            $category->id = null;
            $category->name = 'Uncategorized';
        } else {
            $category = \App\Models\PostCategory::where('slug', '=', $slug)->first();
        }
        if ($category) {
            $page = request('page', 1);
            if (!is_numeric($page)) {
                $page = 1;
            }
            $posts = \App\Repositories\Posts::getMostRecentByCategory($category->id, 10, ($page-1)*10);
            $count = \App\Repositories\Posts::getCountByCategory($category->id);
            $title = $category->name . ' - Blog Categories | ' . config('app.name');
            $header = $category->name;
            $page_url = '/categories/' . $category->name;
            return view('posts.list', compact(
                'page', 'posts', 'count', 'title', 'header', 'page_url'
            ));
        }
    }

    public function tags($slug)
    {
        $tag = \App\Models\PostTag::where('slug', '=', $slug)->first();
        if ($tag) {
            $page = request('page', 1);
            if (!is_numeric($page)) {
                $page = 1;
            }
            $posts = \App\Repositories\Posts::getMostRecentByTag($tag->id, 10, ($page-1)*10);
            $count = \App\Repositories\Posts::getCountByTag($tag->id);
            $title = $tag->name . ' - Blog Tags | ' . config('app.name');
            $header = $tag->name;
            $page_url = '/tags/' . $tag->name;
            return view('posts.list', compact(
                'page', 'posts', 'count', 'title', 'header', 'page_url'
            ));
        }
    }

}
