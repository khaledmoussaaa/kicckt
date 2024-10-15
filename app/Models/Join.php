<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Join extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'team_color',
        'match_id',
        'user_id',
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
    public function players()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // matches -> For each join game hasMany match 
    public function match()
    {
        return $this->belongsTo(MatchGame::class, 'match_id');
    }
}
