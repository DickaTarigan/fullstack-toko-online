<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    public function upload(
        UploadedFile $file,
        string $folder = 'products'
    ): string {
        $filename = uniqid() . '.' . $file->getClientOriginalExtension();
        $file->storeAs($folder, $filename, 'public');
        return $folder . '/' . $filename;
    }

    public function delete(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}