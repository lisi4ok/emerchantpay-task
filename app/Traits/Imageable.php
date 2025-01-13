<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait Imageable
{
    /**
     * Get the model's images.
     *
     * @return MorphMany
     */
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * Update the model's images.
     *
     * @param Collection|array $images
     * @param string|null $storagePath
     * @param array|null $data
     * @return void
     */
    public function uploadImages(Collection|array $images, string $storagePath = null, array $data = null): void
    {
        if ($storagePath === null) {
            $parts = explode('\\', static::class);
            $storagePath = Str::lower(end($parts));
        }

        foreach ($images as $image) {
            $this->images()->forceFill([
                'path' => $image->storePublicly(
                    $storagePath, ['disk' => Image::storageDisk()]
                ),
                'data' => $data,
            ])->save();
        }
    }

    /**
     *  Delete the model's images.
     *
     * @return void
     */
    public function deleteImages(): void
    {
        $images = $this->images();
        if ($images > 0) {
            foreach ($images as $image) {
                Storage::disk(Image::storageDisk())->delete($image);
            }
            $images->forceDelete();
        }
    }
}
