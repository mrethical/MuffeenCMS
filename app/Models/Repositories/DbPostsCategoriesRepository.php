<?php

namespace App\Models\Repositories;

use App\Models\PostsCategory;

class DbPostsCategoriesRepository implements PostsCategoriesRepositoryInterface
{

    private $_posts_categories;

    function __construct()
    {
        $this->_posts_categories = new PostsCategory();
    }

    public function getAll()
    {
        return PostsCategory::all();
    }

    public function getCountAll()
    {
        return PostsCategory::count();
    }

    public function getAllWithLimit($limit, $offset)
    {
        return PostsCategory::take($limit)->offset($offset)->get();
    }

    public function getPairAll()
    {
        $categories = PostsCategory::pluck('name', 'id');
        $list = array();
        foreach ($categories as $id=>$name) {
            $list[$id] = $name;
        }
        return $list;
    }

    private function _getFamily($id)
    {
        $not_possible_parent = [$id];
        $children = $this->_posts_categories->where('parent_id', $id)->get();
        foreach ($children as $child)
        {
            $not_possible_parent = array_merge($not_possible_parent, $this->_getFamily($child->id));
        }
        return $not_possible_parent;
    }

    public function getPossibleParent($id)
    {
        return PostsCategory::whereNotIn('id', $this->_getFamily($id))->get();
    }

}