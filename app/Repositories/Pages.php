<?php

namespace App\Repositories;

use App\Models\Page;
use DB;

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

    public static function getLatestOnLastThirtyDaysWithLimit($limit)
    {
        return Page::where(DB::raw("DATEDIFF(NOW(), 'created_at')", '<=', 30))
            ->limit($limit)
            ->get();
    }

}