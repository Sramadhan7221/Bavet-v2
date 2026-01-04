<?php
// app/Services/HomeContentService.php

namespace App\Services;

use App\Models\HomeContent;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class HomeContentService
{
    public function __construct(
        private FileService $fileService
    ) {}

    /**
     * Update hero section
     */
    public function updateHero(array $validated, ?UploadedFile $imageFile = null): HomeContent
    {
        $homeContent = HomeContent::getInstance();

        if ($imageFile) {
            // Hapus file lama
            if ($homeContent->image_hero) {
                $this->fileService->deleteFile($homeContent->image_hero);
            }

            // Upload file baru
            $filename = sprintf('hero-%s', Str::uuid());
            $path = $this->fileService->saveFile($imageFile, $filename, 'home');
            $validated['image_hero'] = url($path);
        }

        $homeContent->fill($validated);
        $homeContent->save();

        return $homeContent;
    }

    /**
     * Update vision & mission section
     */
    public function updateVisionMission(array $validated, ?UploadedFile $bannerFile = null): HomeContent
    {
        $homeContent = HomeContent::getInstance();

        if ($bannerFile) {
            // Hapus file lama
            if ($homeContent->vm_banner) {
                $this->fileService->deleteFile($homeContent->vm_banner);
            }

            // Upload file baru
            $filename = sprintf('vm-banner-%s', Str::uuid());
            $path = $this->fileService->saveFile($bannerFile, $filename, 'home');
            $validated['vm_banner'] = url($path);
        }

        $homeContent->fill($validated);
        $homeContent->save();

        return $homeContent;
    }

    /**
     * Update pengujian section
     */
    public function updatePengujian(array $validated): HomeContent
    {
        $homeContent = HomeContent::getInstance();
        $homeContent->fill($validated);
        $homeContent->save();

        return $homeContent;
    }
}