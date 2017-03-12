<?php

namespace App\Models\Repositories;

use App\Models\Post;
use DB;

class DbPostsRepository implements PostsRepositoryInterface
{

    public function getAll()
    {
        return Post::all();
    }

    public function getCountAll()
    {
        return Post::count();
    }

    public function getAllWithLimit($limit, $offset)
    {
        return Post::take($limit)->offset($offset)->get();
    }

    public function getPairAll()
    {
        $posts = Post::pluck('title', 'id');
        $list = array();
        foreach ($posts as $id=>$title) {
            $list[$id] = $title;
        }
        return $list;
    }

    public function getByID($id)
    {
        return Post::where('id', $id);
    }

    public function getBySlug($slug)
    {
        return Post::where('slug', $slug)->first();
    }

}