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

    public function getByID($id)
    {
        return Post::where('id', $id);
    }

}