<?php

namespace App\Models\Repositories;

use App\Models\User;
use DB;

class DbUsersRepository implements UsersRepositoryInterface
{

    private $_posts_categories;

    function __construct()
    {
        $this->_posts_categories = new User();
    }

    public function getAll()
    {
        return User::all();
    }

    public function getCountAll()
    {
        return User::count();
    }

    public function getAllWithLimit($limit, $offset)
    {
        return User::take($limit)->offset($offset)->get();
    }

    public function getByID($id)
    {
        return User::where('id', $id);
    }

}