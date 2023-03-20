<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

trait UploadFile
{
    protected function uploadImage(UploadedFile $file, string $directory): string
    {
        $fileName = time() . '.' . $file->extension();
        $isFileMoved = $file->storeAs($directory, $fileName, 'public');

        if (!$isFileMoved) {
            return response()->json([
                'message' => 'Failed to upload file.',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $fileName;
    }

    protected function uploadDeleteImage(string $path): void
    {
        Storage::disk('public')->delete('images/' . $path);
    }
}
