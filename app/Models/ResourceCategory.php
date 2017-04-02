<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResourceCategory extends Model
{
    protected $table = 'resources_categories';

    protected $fillable = [
        'name'
    ];
}
