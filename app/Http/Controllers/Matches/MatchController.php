<?php

namespace App\Http\Controllers\Matches;

use App\Http\Controllers\Controller;
use App\Http\Requests\GameMatches\EndMatchRequest;
use App\Http\Requests\GameMatches\MatchRequest;
use App\Models\MatchGame;
use App\Models\PlayerMonth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MatchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $date = $request->date ? Carbon::parse($request->date) : Carbon::now();
        $matches = MatchGame::getMatches($date);
        return contentResponse($matches);
    }

    /**
     * Display a listing of the resource.
     */
    public function pervious()
    {
        $matches = MatchGame::getMatches(null, true, auth_id());
        return contentResponse($matches);
    }

    /**
     * Display the specified resource.
     */
    public function show(MatchGame $match)
    {
        $match = $match->load('staduim.media', 'joins.user.media');
        $match->joins->transform(function ($join) {
            $join->user->team_color = $join->team_color;
            $join->user->join_id = $join->id;
            $join->user->position = $join->position;
            return $join->user;
        });
        return contentResponse($match->load('manOfTheMatch.media'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MatchRequest $request)
    {
        $match = MatchGame::create($request->validated());
        return messageResponse();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MatchRequest $request, MatchGame $match)
    {
        $match->update($request->validated());
        return messageResponse();
    }

    /**
     * End Finish Match.
     */
    public function finish(EndMatchRequest $request, MatchGame $match)
    {
        $joins = collect($request->input('joins'))->toArray();

        // Upsert the join data for the match
        $joinsData = $match->joins()->upsert($joins, ['id'], ['id', 'goals', 'assists', 'goal_keeper', 'user_id']);

        foreach ($joins as $join) {
            // Find or create the PlayerMonth record for the current user
            $playerMonth = PlayerMonth::where('user_id', $join['user_id'])
                ->whereMonth('created_at', now())
                ->first();

            // If the PlayerMonth record doesn't exist, create it
            if (!$playerMonth) {
                $playerMonth = PlayerMonth::create($join);
            } else {
                // Increment individual stats for the player without merging all fields
                $playerMonth->increment('goals', $join['goals']);
                $playerMonth->increment('assists', $join['assists']);
                $playerMonth->increment('goal_keeper', $join['goal_keeper']);
            }

            // Calculate the points based on the updated stats
            $points = ($playerMonth->goals * 3) + ($playerMonth->assists * 1) + ($playerMonth->goal_keeper * 1);

            // Update the points
            $playerMonth->update(['points' => $points]);
        }

        // Update the match as finished
        $match->update($request->validated() + ['is_finished' => 1]);

        // Return success response
        return messageResponse();
    }

    /**
     * Delete the specified resource from storage.
     */
    public function destroy(MatchGame $match)
    {
        $match->forceDelete();
        return messageResponse();
    }
}
