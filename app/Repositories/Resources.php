<?php

namespace App\Repositories;

use App\Models\Resource;
use App\Services\Uploads;

class Resources
{

    public static function getAllByName()
    {
        return Resource::select(['id', 'name', 'title'])
            ->orderBy('name')
            ->get();
    }

    public static function getAllByCategoryByName($category_id)
    {
        if (!$category_id) {
            $category_id = null;
        }
        return Resource::select(['id', 'name', 'title'])
            ->where('category_id', $category_id)
            ->orderBy('name')
            ->get();
    }

    public static function getAllImageByName()
    {
        return Resource::select(['id', 'name', 'title'])
            ->whereIn('ext', Uploads::imageExtensions())
            ->orderBy('name')
            ->get();
    }

    public static function getImagesByCategoryByName($category_id)
    {
        if (!$category_id) {
            $category_id = null;
        }
        return Resource::select(['id', 'name', 'title'])
            ->where('category_id', $category_id)
            ->whereIn('ext', Uploads::imageExtensions())
            ->orderBy('name')
            ->get();
    }

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