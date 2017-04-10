<?php

namespace App\Repositories;

use App\Models\PostTag;

class PostTags
{

    public static function getAllByName()
    {
        return PostTag::orderBy('name')
            ->get();
    }

    public static function getAllWithLimit($limit, $offset = 0)
    {
        return PostTag::select(['id', 'name', 'slug'])
            ->orderBy('name')
            ->take($limit)
            ->offset($offset)
            ->get();
    }

    public static function getCount()
    {
        return PostTag::count();
    }

    public static function searchByColumn($column, $keyword)
    {
        return PostTag::where($column, 'like', '%' . $keyword . '%')->pluck('name');
    }

}