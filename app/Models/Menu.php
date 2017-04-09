<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['name', 'menu_group_id', 'url', 'parent_id'];

    public function order()
    {
        return $this->hasOne('App\Models\MenuOrder', 'menu_id');
    }

    public function menus()
    {
        return $this->hasMany('App\Models\Menu', 'parent_id');
    }

}
