<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

trait UploadFile
{
    /**
     * It uploads an image to the server and returns the name of the file
     * 
     * @param UploadedFile file The file that was uploaded.
     * @param string directory The directory where the file will be stored.
     * 
     * @return string The file name of the uploaded file.
     */
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

    /**
     * Delete the image from the storage
     * 
     * @param string path The path to the image to be deleted.
     */
    protected function uploadDeleteImage(string $path): void
    {
        Storage::disk('public')->delete('images/' . $path);
    }
}
