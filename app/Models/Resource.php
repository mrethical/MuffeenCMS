<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'title', 'alt', 'size', 'ext'
    ];

    protected static $upload_location = '/uploads';
    protected static $upload_location_images_small = '/uploads/images-small';
    protected static $upload_location_images_medium = '/uploads/images-medium';

    public static function getUploadLocations()
    {
        $locations['upload'] = storage_path('public' . Resource::$upload_location);
        $locations['upload_images_small'] = storage_path('public' . Resource::$upload_location_images_small);
        $locations['upload_images_medium'] = storage_path('public' . Resource::$upload_location_images_medium);
        return $locations;
    }

    public static function getUrlLocations()
    {
        $locations['upload'] = url(Resource::$upload_location);
        $locations['upload_images_small'] = url(Resource::$upload_location_images_small);
        $locations['upload_images_medium'] = url(Resource::$upload_location_images_medium);
        return $locations;
    }

}
