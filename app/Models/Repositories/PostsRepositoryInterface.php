<?php

namespace App\Models\Repositories;

interface PostsRepositoryInterface
{
    public function getAll();
    public function getCountAll();
    public function getAllWithLimit($limit, $offset);
    public function getPairAll();
    public function getByID($id);
}