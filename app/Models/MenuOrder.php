<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuOrder extends Model
{
    protected $table = 'menu_order';

    protected $fillable = ['menu_id', 'parent_menu_id', 'order'];
}
