<?php

namespace App\Models\Repositories;

use App\Models\Resource;

class DbResourcesRepository implements ResourcesRepositoryInterface
{

    private $_resources_categories;

    function __construct()
    {
        $this->_resources_categories = new Resource();
    }

    public function getAll()
    {
        return Resource::all();
    }

    public function getCountAll()
    {
        return Resource::count();
    }

    public function getAllWithLimit($limit, $offset)
    {
        return Resource::take($limit)->offset($offset)->get();
    }

    public function getAllImages()
    {
        return Resource::whereIn('ext', ['jpeg', 'jpg', 'png', 'gif'])->get();
    }

    public function getUncategorized()
    {
        return Resource::where('category_id', null)->get();
    }

    public function getUncategorizedImages()
    {
        return Resource::where('category_id', null)->whereIn('ext', ['jpeg', 'jpg', 'png', 'gif'])->get();
    }

}