<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'category_id', 'resource_id', 'resource_attributes', 'content', 'slug', 'author'];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'author');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\PostCategory', 'category_id');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Models\PostTag', 'posts_tags_relation', 'post_id', 'tag_id');
    }

    public function resource()
    {
        return $this->belongsTo('App\Models\Resource');
    }
}
