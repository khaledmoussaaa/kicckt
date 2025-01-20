<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

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
        'purple_goals',
        'joining_numbers',
        'man_of_the_match',
        'google_drive_link',
        'staduim_id',
        'is_finished'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'datetime:d-m-Y',
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

    // players -> For each match hasMany players in match and for each player has one match
    public function manOfTheMatch()
    {
        return $this->belongsTo(User::class, 'man_of_the_match')->withTrashed();
    }

    // Method to retrieve and transform the matches
    public static function getMatches($date = null, $isFinished = null, $userId = null)
    {
        // If a date is passed, use it; otherwise, use the current date
        $date = Carbon::parse($date);

        // Build the query
        $query = self::with(['joins.user.media', 'staduim.media']);

        // Apply the "is_finished" filter if provided
        if ($isFinished !== null) {
            $query->where('is_finished', $isFinished);
        } else {
            $query->whereDate('date', $date);
        }

        // Apply the user filter if provided (for the "previous" method)
        if ($userId) {
            $query->whereHas('joins.user', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            });
        }

        // Paginate the results
        $matches = $query->latest()->paginate(10);

        // Transform the collection
        $matches->getCollection()->transform(function ($match) {
            $match->joins = $match->joins->transform(function ($join) {
                return $join->user;
            });
            return $match;
        });

        return $matches;
    }
}
