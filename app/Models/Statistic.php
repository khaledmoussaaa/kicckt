<?php

namespace App\Models;

class Statistic extends BaseModel
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
        'user_id',
        'match_id',
    ];

    // ======================= Relationships ======================= //
    // User -> For each match belongs to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
