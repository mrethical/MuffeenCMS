<?php

namespace App\Models\Repositories;

interface ResourcesRepositoryInterface
{
    public function getAll();
    public function getCountAll();
    public function getAllWithLimit($limit, $offset);
    public function getAllImages();
    public function getUncategorized();
    public function getUncategorizedImages();
}