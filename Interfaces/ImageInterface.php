<?php
namespace App\Interfaces;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;

interface ImageInterface
{
    /**
     * Get the model's images.
     *
     * @return MorphMany
     */
    public function images(): MorphMany;

    /**
     * Update the model's images.
     *
     * @param Collection $images
     * @param string|null $storagePath
     * @return void
     */
    public function uploadImages(Collection $images, string $storagePath = null): void;

    /**
     *  Delete the model's images.
     *
     * @return void
     */
    public function deleteImages(): void;
}
