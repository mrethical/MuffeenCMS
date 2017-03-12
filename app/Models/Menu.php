<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'post_id', 'parent_id'
    ];

    /**
     * Get the post for the category.
     */
    public function post()
    {
        return $this->belongsTo('App\Models\Post', 'post_id');
    }

    /**
     * Get child menus for the menu.
     */
    public function children()
    {
        return $this->hasMany('App\Models\Menu', 'parent_id');
    }

    /**
     * Get parent menu for the menu.
     */
    public function parent()
    {
        return $this->belongsTo('App\Models\Menu', 'parent_id');
    }
}
