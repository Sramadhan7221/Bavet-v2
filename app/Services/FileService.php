<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

class FileService
{
    public function saveFile(UploadedFile $file, string $filename, string $path): string
    {
        $renamedFile = sprintf(
            '%s.%s',
            $this->sanitizeFileName(Str::lower($filename)),
            $file->getClientOriginalExtension()
        );

        $file->storeAs($path, $renamedFile, 'public');

        return Storage::url("$path/$renamedFile");
    }

    public function deleteFile(?string $publicUrl): bool
    {
        try {
            if(!$publicUrl)
                return false;
            // Ambil hanya bagian path setelah domain
            $parsedPath = parse_url($publicUrl, PHP_URL_PATH);
            $relativePath = Str::after($parsedPath, '/storage/');

            if (Storage::disk('public')->exists($relativePath)) {
                return Storage::disk('public')->delete($relativePath);
            }

            return false;
        } catch (\Throwable $th) {
            report($th);
            return false;
        }
    }


    protected function sanitizeFileName(string $name): string
    {
        return preg_replace('/[^a-zA-Z0-9-_]/', '_', $name);
    }
}

