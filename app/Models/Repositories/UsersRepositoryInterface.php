<?php

namespace App\Models\Repositories;

interface UsersRepositoryInterface
{
    public function getAll();
    public function getCountAll();
    public function getAllWithLimit($limit, $offset);
    public function getByID($id);
}