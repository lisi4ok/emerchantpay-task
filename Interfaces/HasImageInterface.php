<?php
namespace App\Interfaces;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Http\UploadedFile;

interface HasImageInterface
{
    /**
     * Update the model's image.
     *
     * @param UploadedFile $image
     * @param string|null $storagePath
     * @return void
     */
    public function updateImage(UploadedFile $image, string $storagePath = null): void;

    /**
     *  Delete the model's image.
     *
     * @return void
     */
    public function deleteImage(): void;

    /**
     * Get the URL to the model's image.
     *
     * @return Attribute
     */
    public function imageUrl(): Attribute;

    /**
     * Get the URL to the model's default image.
     *
     * @return Attribute
     */
    public function defaultImageUrl(): Attribute;
}
