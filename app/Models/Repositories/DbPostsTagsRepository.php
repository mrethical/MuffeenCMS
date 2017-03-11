<?php

namespace App\Models\Repositories;

use App\Models\PostsTag;

class DbPostsTagsRepository implements PostsTagsRepositoryInterface
{

    private $_posts_categories;

    function __construct()
    {
        $this->_posts_categories = new PostsTag();
    }

    public function getAll()
    {
        return PostsTag::all();
    }

    public function getCountAll()
    {
        return PostsTag::count();
    }

    public function getAllWithLimit($limit, $offset)
    {
        return PostsTag::take($limit)->offset($offset)->get();
    }

    public function searchByColumn($column, $keyword)
    {
        return PostsTag::where($column, 'like', '%' . $keyword . '%')->get();
    }

}