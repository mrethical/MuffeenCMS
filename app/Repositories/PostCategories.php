<?php

namespace App\Repositories;

use App\Models\PostCategory;

class PostCategories
{

    public static function getAllByName()
    {
        return PostCategory::orderBy('name')
            ->get();
    }

    public static function getAllWithLimit($limit, $offset = 0)
    {
        return PostCategory::select(['id', 'name', 'parent_id'])
            ->with(array('parent' => function($query){
                $query->select('id','name');
            }))
            ->take($limit)
            ->offset($offset)
            ->get();
    }

    public static function getCount()
    {
        return PostCategory::count();
    }

    private static function getFamily($id)
    {
        $not_possible_parent = [$id];
        $children = PostCategory::where('parent_id', $id)->get();
        foreach ($children as $child)
        {
            $not_possible_parent = array_merge($not_possible_parent, self::getFamily($child->id));
        }
        return $not_possible_parent;
    }

    public static function getPossibleParent($id)
    {
        return PostCategory::whereNotIn('id', self::getFamily($id))->get();
    }

}