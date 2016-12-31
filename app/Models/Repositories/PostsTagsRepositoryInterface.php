<?php

namespace App\Models\Repositories;

interface PostsTagsRepositoryInterface
{
    public function getAll();
    public function getCountAll();
    public function getAllWithLimit($limit, $offset);
    public function searchByColumn($column, $keyword);
}