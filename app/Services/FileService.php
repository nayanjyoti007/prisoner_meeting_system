<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class FileService
{
    public static function save($image, $folder)
    {
        $image_extension = $image->getClientOriginalExtension();
        $image_name = md5(now() . time()) . "-" . uniqid() . "." . $image_extension;
        $storagePath = '/backend_images/' . $folder . $image_name;
        Storage::disk('public')->put($storagePath, file_get_contents($image->getRealPath()));

        return $image_name;
    }

    public static function delete($image, $folder)
    {
        $storagePath = 'backend_images/' . $folder . $image;

        if (Storage::disk('public')->exists($storagePath)) {
            Storage::disk('public')->delete($storagePath);
        }

        return true;
    }
}
