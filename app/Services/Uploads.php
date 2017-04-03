<?php

namespace App\Services;

use ErrorException;
use File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Uploads
{

    public function __construct()
    {
        if ($this->prepareDirectories()) {
            $this->createSymlink();
        }
    }

    const SMALL_WIDTH = 240;
    const MEDIUM_WIDTH = 720;

    protected static $upload_location = '/uploads';
    protected static $upload_location_images_small = '/uploads/images-small';
    protected static $upload_location_images_medium = '/uploads/images-medium';

    private function getUploadDirectories()
    {
        $locations = [];
        $locations['upload'] = storage_path(self::$upload_location);
        $locations['upload_images_small'] = storage_path(self::$upload_location_images_small);
        $locations['upload_images_medium'] = storage_path(self::$upload_location_images_medium);
        return $locations;
    }

    public static function getUploadUrls()
    {
        $locations = [];
        $locations['upload'] = url(self::$upload_location);
        $locations['upload_images_small'] = url(self::$upload_location_images_small);
        $locations['upload_images_medium'] = url(self::$upload_location_images_medium);
        return $locations;
    }

    private function prepareDirectories()
    {
        $locations = $this->getUploadDirectories();
        $upload = $locations ['upload'];
        $upload_images_small = $locations ['upload_images_small'];
        $upload_images_medium = $locations['upload_images_medium'];
        if (!File::exists($upload)) {
            File::makeDirectory($upload, $mode = 0755, $recursive = true, $force = false);
        }
        if (!File::exists($upload_images_small)) {
            File::makeDirectory($upload_images_small, $mode = 0755, $recursive = true, $force = false);
        }
        if (!File::exists($upload_images_medium)) {
            File::makeDirectory($upload_images_medium, $mode = 0755, $recursive = true, $force = false);
        }
        return true;
    }

    private function createSymlink()
    {
        if (!File::exists(public_path(self::$upload_location))) {
            symlink(storage_path(self::$upload_location), public_path(self::$upload_location));
        }
        return true;
    }

    private static function isImage(UploadedFile $file)
    {
        return in_array(
            strtolower($file->guessClientExtension()),
            ['jpg', 'jpeg', 'png', 'gif']
        );
    }

    private function createDuplicate($filename)
    {
        $locations = $this->getUploadDirectories();
        $target_path = $locations['upload'] . '/' . $filename;
        $small = $locations['upload_images_small'] . '/' . $filename;
        $medium = $locations['upload_images_medium'] . '/' . $filename;
        list($width,$height) = getimagesize($target_path);
        $small_ratio = self::SMALL_WIDTH/$width;
        $small_width = self::SMALL_WIDTH;
        $small_height = $height * $small_ratio;
        $medium_ratio = self::MEDIUM_WIDTH/$width;
        $medium_width = self::MEDIUM_WIDTH;
        $medium_height = $height * $medium_ratio;
        $small_create = imagecreatetruecolor($small_width,$small_height);
        $medium_create = imagecreatetruecolor($medium_width,$medium_height);
        $filename_err = explode(".", $target_path);
        $filename_err_count = count($filename_err);
        $file_ext = $filename_err[$filename_err_count-1];
        switch($file_ext){
            case 'jpg' || 'jpeg':
                $small_source = imagecreatefromjpeg($target_path);
                break;
            case 'png':
                $small_source = imagecreatefrompng($target_path);
                break;
            case 'gif':
                $small_source = imagecreatefromgif($target_path);
                break;
            default:
                $small_source = imagecreatefromjpeg($target_path);
        }
        $medium_source = $small_source;
        imagecopyresampled($small_create, $small_source, 0, 0, 0, 0, $small_width, $small_height, $width, $height);
        imagecopyresampled($medium_create, $medium_source, 0, 0, 0, 0, $medium_width, $medium_height, $width, $height);
        switch($file_ext){
            case 'jpg' || 'jpeg':
                imagejpeg($small_create, $small, 80);
                imagejpeg($medium_create, $medium, 80);
                break;
            case 'png':
                imagepng($small_create, $small, 80);
                imagepng($medium_create, $medium, 80);
                break;
            case 'gif':
                imagegif($small_create, $small);
                imagegif($medium_create, $medium);
                break;
            default:
                imagejpeg($small_create, $small, 80);
                imagejpeg($medium_create, $medium, 80);
        }
        return TRUE;
    }

    public function save(UploadedFile $file, $name = null)
    {
        $locations = $this->getUploadDirectories();
        if ($name === null) {
            $name = $file->getClientOriginalName();
        }
        $same_file = 1;
        while (File::exists($locations['upload'] . '/' . $name)) {
            $temp = explode('.', $file->getClientOriginalName());
            if (count($temp) > 1) {
                $ext = array_pop($temp);
                $name = implode('.',  $temp) . ++$same_file . '.' . $ext;
            } else {
                $name .= ++$same_file;
            }
        }
        $file->move($locations['upload'], $name);
        if (self::isImage($file)) {
            $this->createDuplicate($name);
        }
        return $name;
    }

}