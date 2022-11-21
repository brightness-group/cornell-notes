<?php

namespace App\Utils;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Statamic\Facades\GlobalSet;

class Media
{
    public static function upload($request, $name, $folder)
    {
        $originalName = $request->file($name)->getClientOriginalName();
        $sluggedName = Str::slug(pathinfo($originalName, PATHINFO_FILENAME), '-');
        $extension = $request->file($name)->getClientOriginalExtension();
        $fileName = $sluggedName.'_'.time().'.'.$extension;

        $request->file($name)->storeAs($folder, $fileName);

        return Storage::url("{$folder}/{$fileName}");
    }

    public static function folderSize($directory, $unit = true)
    {
        $fileSize = 0;

        foreach (Storage::files($directory) as $file) {
            $fileSize += Storage::size($file);
        }

        if ($unit) {
            return self::unitConverter($unit);
        }

        return $fileSize;
    }

    public static function memoryLimit()
    {
        $config = GlobalSet::findByHandle('cornell_notes')->in('default');

        $unit = $config->get('unit');
        $memory = $config->get('memory');
        $bytes = 0;

        if ($unit === 'MB') {
            $bytes = round($memory * 1024 * 1024, 4);
        } else if($unit === 'GB') {
            $bytes = round($memory * 1024 * 1024 * 1024, 4);
        } else {
            $bytes = round($memory * 1024, 4);
        }

        return $bytes;
    }

    public static function unitConverter($bytes)
    {
        if ($bytes > 0) {
            $factor = floor(log($bytes, 1024));
            $size = array('B', 'KB', 'MB', 'GB');

            return sprintf('%.01F', $bytes / pow(1024, $factor)) . ' ' .  @$size[$factor];
        }

        return $bytes;
    }
}
