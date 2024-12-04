<?php

namespace App\Models;

class PlayerMonth extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'goals',
        'assists',
        'goal_keeper',
        'points',
        'user_id',
    ];

    // ======================= Relationships ======================= //
    // User -> For each match belongs to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
