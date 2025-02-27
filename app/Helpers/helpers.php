<?php

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

function uploadFile($files = [], $disk = "Files", $path = "", $useOriginalName = false, $overwrite = false, $fileNameInArray = true)
{
    $uploadedPaths = [];

    if (!is_array($files)) {
        $files = [$files];
    }

    foreach ($files as $key => $file) {
        if ($file instanceof UploadedFile && $file->isValid()) {
            $fileName = $useOriginalName ? $file->getClientOriginalName() : uniqid() . '.' . $file->getClientOriginalExtension();

            if ($overwrite && Storage::disk($disk)->exists($path . '/' . $fileName)) {
                Storage::disk($disk)->delete($path . '/' . $fileName);
            }

            $storedPath = $file->storeAs($path, $fileName, $disk);

            if ($fileNameInArray) {
                $uploadedPaths[$key] = $storedPath;
            } else {
                $uploadedPaths[] = $storedPath;
            }
        }
    }

    return $fileNameInArray ? $uploadedPaths : reset($uploadedPaths);
}
