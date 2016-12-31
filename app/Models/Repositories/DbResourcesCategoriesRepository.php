<?php

namespace App\Models\Repositories;

use App\Models\ResourcesCategory;

class DbResourcesCategoriesRepository implements ResourcesCategoriesRepositoryInterface
{

    private $_resources_categories;

    function __construct()
    {
        $this->_resources_categories = new ResourcesCategory();
    }

    public function getAll()
    {
        return ResourcesCategory::all();
    }

    public function getCountAll()
    {
        return ResourcesCategory::count();
    }

    public function getAllWithLimit($limit, $offset)
    {
        return ResourcesCategory::take($limit)->offset($offset)->get();
    }

    public function getPairAll()
    {
        $categories = ResourcesCategory::pluck('name', 'id');
        $list = array();
        foreach ($categories as $id=>$name) {
            $list[$id] = $name;
        }
        return $list;
    }

    public function getByID($id)
    {
        return ResourcesCategory::find($id);
    }

}