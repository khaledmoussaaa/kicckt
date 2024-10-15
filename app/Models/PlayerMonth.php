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

    // /**
    //  * The attributes that should be hidden for serialization.
    //  *
    //  * @var array<int, string>
    //  */
    // protected $hidden = [
    //     'created_at',
    //     'updated_at',
    // ];
    // ======================= Relationships ======================= //

    // User -> For each match belongs to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
