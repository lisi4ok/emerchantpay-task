<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait HasImage
{
    protected static string $imageDisk = 'public';
    public static string $defaultImagePath = '/static/image-placeholder.svg';

    protected static function boot() {
        parent::boot();
        static::deleting(function($model) {
            $model->deleteImage();
        });
    }

    /**
     * Update the model's image.
     *
     * @param UploadedFile $image
     * @param string|null $storagePath
     * @return void
     */
    public function updateImage(UploadedFile $image, string $storagePath = null): void
    {
        if ($storagePath === null) {
            $parts = explode('\\', static::class);
            $storagePath = Str::lower(end($parts));
        }

        tap($this->image, function ($previous) use ($image, $storagePath) {
            $this->forceFill([
                'image' => $image->storePublicly(
                    $storagePath, ['disk' => $this->imageDisk()]
                ),
            ])->save();

            if ($previous) {
                Storage::disk($this->imageDisk())->delete($previous);
            }
        });
    }

    /**
     *  Delete the model's image.
     * @return void
     */
    public function deleteImage(): void
    {
        if ($this->image === null) {
            return;
        }

        Storage::disk($this->imageDisk())->delete($this->image);

        $this->forceFill([
            'image' => null,
        ])->save();
    }

    /**
     * Get the URL to the model's image.
     *
     * @return Attribute
     */
    public function imageUrl(): Attribute
    {
        return Attribute::get(function (): string {
            return ($this->image && Storage::disk($this->imageDisk())->exists($this->image))
                ? Storage::disk($this->imageDisk())->url($this->image)
                : $this->default_image_url;
        });
    }

    /**
     * Get the URL to the model's default image.
     *
     * @return Attribute
     */
    public function defaultImageUrl(): Attribute
    {
        return Attribute::get(function (): string {
            return url(static::$defaultImagePath);
        });
    }

    /**
     * Get the disk that image should be stored on.
     *
     * @return string
     */
    protected function imageDisk(): string
    {
        return static::$imageDisk;
    }
}
