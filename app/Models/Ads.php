<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Ads extends BaseModel implements HasMedia
{
    use InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'url',
    ];

    // Spatie Media Library Collections
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('ads')->singleFile();
    }
}
