<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'content', 'slug'
    ];

    /**
     * The tags that belong to the post.
     */
    public function tags()
    {
        return $this->belongsToMany('App\Models\PostsTag', 'posts_tags_relation', 'post_id', 'tag_id');
    }

}
