<?php

namespace App\Repositories;

use App\Models\Inquiry;

class Inquiries
{

    public static function getAllWithLimit($limit, $offset = 0)
    {
        return Inquiry::select(['id', 'name', 'email', 'subject', 'message', 'created_at'])
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->offset($offset)
            ->get();
    }

    public static function getCount()
    {
        return Inquiry::count();
    }

}