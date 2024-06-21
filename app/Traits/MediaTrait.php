<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait MediaTrait
{
    public static function upload($image, string $dir): string
    {
        $uniqueFileName = uniqid() . '.' . $image->extension();
        return $image->storeAs($dir, $uniqueFileName, 'uploads');
    }

    public static function uploadVideo($video, string $dir): string
    {
        $uniqueFileName = uniqid() . '.' . $video->extension();
        return $video->storeAs($dir, $uniqueFileName, 'public');
    }

    public static function delete(string $FullImagePath): bool|string
    {
        $updatedPath = str_replace('http://127.0.0.1:8000/', '', $FullImagePath);

        if (File::exists($updatedPath)) {
            File::delete($updatedPath);
            return true;

        }
        return 'not found';
    }

}

