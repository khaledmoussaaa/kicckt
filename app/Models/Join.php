<?php

namespace App\Models;

class Join extends BaseModel
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
        'team_color',
        'position',
        'user_id',
        'match_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime:d-m-y h:m:s:a',
        'updated_at' => 'datetime:d-m-y h:m:s:a',
    ];

    // ======================= Relationships ======================= //
    // players -> For each match hasMany players in match and for each player has one match
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    // matches -> For each join game hasMany match 
    public function match()
    {
        return $this->belongsTo(MatchGame::class, 'match_id');
    }
}
