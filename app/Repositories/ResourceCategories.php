<?php

namespace App\Repositories;

use App\Models\ResourceCategory;

class ResourceCategories
{

    public static function getAllByName()
    {
        return ResourceCategory::orderBy('name')
            ->get();
    }

    public static function getAllWithLimit($limit, $offset = 0)
    {
        return ResourceCategory::select(['id', 'name'])
            ->take($limit)
            ->offset($offset)
            ->get();
    }

    public static function getCount()
    {
        return ResourceCategory::count();
    }

}