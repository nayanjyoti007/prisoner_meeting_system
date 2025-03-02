<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;



class ImageResize
{
    public static function save($image,$width,$height,$folder)
    {
        $manager = new ImageManager(new Driver());
        $image_extension = $image->getClientOriginalExtension();
        $image_name = md5(date('now') . time()) . "-" . uniqid() . "." . "$image_extension";
        $image = $manager->read($image);
        $image = $image->resize($width, $height);
        $storagePath = '/backend_images/'.$folder . $image_name;
        Storage::disk('public')->put($storagePath, $image->encode());
        return $image_name;
    }

    public static function delete($image,$folder)
    {
        $storagePath = '/backend_images/'.$folder . $image;
        if (Storage::disk('public')->exists($storagePath)) {
            // dd($storagePath);
            Storage::disk('public')->delete($storagePath);
        }
        return true;
    }
}
