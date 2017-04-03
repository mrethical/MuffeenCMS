<?php

namespace App\Repositories;

use App\Models\Resource;

class Resources
{

    public static function getAllWithLimit($limit, $offset = 0)
    {
        return Resource::select(['id', 'name', 'category_id', 'title', 'alt', 'ext', 'size', 'created_at'])
            ->with(array('category' => function($query){
                $query->select('id','name');
            }))
            ->orderBy('created_at')
            ->take($limit)
            ->offset($offset)
            ->get();
    }

    public static function getCount()
    {
        return Resource::count();
    }

}