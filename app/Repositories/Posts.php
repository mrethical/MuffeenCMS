<?php

namespace App\Repositories;

use App\Models\Post;

class Posts
{

    public static function getAllWithLimit($limit, $offset = 0)
    {
        return Post::select(['id', 'title', 'author', 'category_id', 'slug', 'created_at'])
            ->with([
                'category' => function($query){
                    $query->select('id','name');
                },
                'author' => function($query) {
                    $query->select('id', 'name');
                }
            ])
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->offset($offset)
            ->get();

    }

    public static function getCount()
    {
        return Post::count();
    }

}