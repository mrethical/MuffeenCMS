<?php

namespace App\Models\Repositories;

interface ResourcesCategoriesRepositoryInterface
{
    public function getAll();
    public function getCountAll();
    public function getAllWithLimit($limit, $offset);
    public function getPairAll();
    public function getByID($id);
}