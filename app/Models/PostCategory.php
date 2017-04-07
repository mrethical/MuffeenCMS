<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    protected $table = 'posts_categories';

    protected $fillable = [
        'name', 'parent_id', 'slug'
    ];

    public function parent()
    {
        return $this->belongsTo('App\Models\PostCategory', 'parent_id');
    }
}
