<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    /**
     * @var string
     */
    protected static string $storageDisk = 'public';

    /**
     * @var string
     */
    public static string $defaultImagePath = '/static/image-placeholder.svg';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'images';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'image_id',
        'image_type',
        'path',
        'data',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'url',
        'default_url',
    ];

    /**
     * Get the parent imageable model.
     *
     * @return MorphTo
     */
    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the URL to the model's image.
     *
     * @return Attribute
     */
    public function url(): Attribute
    {
        return Attribute::get(function (): string {
            return ($this->path && Storage::disk($this->storageDisk())->exists($this->path))
                ? Storage::disk($this->storageDisk())->url($this->path)
                : $this->default_url;
        });
    }

    /**
     * Get the URL to the model's default image.
     *
     * @param string|null $defaultImagePath
     * @return Attribute
     */
    public function defaultUrl(string $defaultImagePath = null): Attribute
    {
        if ($defaultImagePath !== null) {
            return Attribute::get(function() use($defaultImagePath): string {
                return Storage::disk($this->storageDisk())->url($defaultImagePath);
            });
        }

        return Attribute::get(function (): string {
            return url(static::$defaultImagePath);
        });
    }

    /**
     * Get the disk that image should be stored on.
     *
     * @return string
     */
    public static function storageDisk(): string
    {
        return static::$storageDisk;
    }

}
