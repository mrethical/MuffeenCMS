<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResourcesCategory extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Get the resources for the category.
     */
    public function resources()
    {
        return $this->hasMany('App\Models\Resource', 'category_id');
    }

}
