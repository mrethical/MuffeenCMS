<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $fillable = [
        'name', 'category_id', 'title', 'alt', 'size', 'ext', 'uploaded_by'
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\ResourceCategory', 'category_id');
    }
}
