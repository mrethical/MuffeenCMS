<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuGroup extends Model
{
    protected $fillable = ['id', 'name'];

    public function children()
    {
        return $this->hasMany('App\Models\Menu', 'menu_group_id');
    }
}
