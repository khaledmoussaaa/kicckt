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

    // ======================= Relationships ======================= //
    // User -> For each match belongs to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ======================= Spate Media Library ======================= //
    // Staduim Media Collection
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('beautiful_goal')->singleFile();
    }
}
