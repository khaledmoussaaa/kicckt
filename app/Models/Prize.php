<?php

namespace App\Models;

class Prize extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
    ];

    // ======================= Spate Media Library ======================= //
    // Staduim Media Collection
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('beautiful_goal')->singleFile();
    }
}
