<?php

namespace App\Models\Repositories;

interface MenusRepositoryInterface
{
    public function getAll();
    public function getCountAll();
    public function getAllWithLimit($limit, $offset);
    public function getPairAll();
    public function getAllNoParent();
    public function getPossibleParent($id);
}