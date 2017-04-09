<?php

namespace App\Repositories;

use App\Models\Page;

class Pages
{

    public static function getAllWithLimit($limit, $offset = 0)
    {
        return Page::select(['id', 'title', 'slug', 'created_at'])
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->offset($offset)
            ->get();

    }

    public static function getCount()
    {
        return Page::count();
    }

}