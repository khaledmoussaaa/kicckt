<?php

namespace App\Models;

class MatchGame extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'match_name',
        'date',
        'time_from',
        'time_to',
        'red_goals',
        'purble_goals',
        'joining_numbers',
        'man_of_the_match',
        'staduim_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'datetime:d.m.y',
    ];

    // ======================= Relationships ======================= //

    // Staduim -> For each match has one staduim and for each staduim has many matches
    public function staduim()
    {
        return $this->belongsTo(Staduim::class, 'staduim_id');
    }

    // players -> For each match hasMany players in match and for each player has one match
    public function joins()
    {
        return $this->hasMany(Join::class, 'match_id');
    }
}
