<?php

namespace App\Models;

class Ads extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'url',
    ];

    // ======================= Spate Media Library ======================= //
    // Staduim Media Collection
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('ads')->singleFile();
    }
}
