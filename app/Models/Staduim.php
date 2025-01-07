<?php

namespace App\Models;

class Staduim extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'staduim_name',
        'area',
        'location',
        'players_number',
        'old_price',
        'price',
    ];

    // ======================= Relationships ======================= //

    // Matches -> For each staduim has many matches and for each match belong to one staduim
    public function macthes()
    {
        return $this->hasMany(MatchGame::class, 'staduim_id');
    }

    // ======================= Spate Media Library ======================= //
    // Staduim Media Collection
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('staduims')->singleFile();
    }
}
