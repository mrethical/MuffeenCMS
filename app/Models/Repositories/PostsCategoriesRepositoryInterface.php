<?php

namespace App\Models\Repositories;

interface PostsCategoriesRepositoryInterface
{
    public function getAll();
    public function getCountAll();
    public function getAllWithLimit($limit, $offset);
    public function getPairAll();
    public function getPossibleParent($id);
}