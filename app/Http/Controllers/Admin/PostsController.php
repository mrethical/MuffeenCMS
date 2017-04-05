<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Repositories\PostCategories;
use App\Repositories\ResourceCategories;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostsController extends Controller
{

    public function index()
    {
        //
    }

    public function create()
    {
        $this->authorize('create', Post::class);

        $post = new Post;
        $categories = PostCategories::getAllByName();
        return view('admin.posts.create', compact('post', 'categories'));
    }

    public function store(Request $request)
    {
        //
    }

    public function edit(Post $post)
    {
        //
    }

    public function update(Request $request, Post $post)
    {
        //
    }

    public function destroy(Post $post)
    {
        //
    }

}
