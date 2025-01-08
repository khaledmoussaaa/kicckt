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
            return $join->user;
        });
        return contentResponse($match->load('manOfTheMatchpla.media'));
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
        $joinsData = $match->joins()->upsert($joins, ['id'], ['id', 'goals', 'assists', 'goal_keeper', 'user_id']);
        foreach ($joins as $join) {
            $playerMonth = PlayerMonth::where('user_id', $join['user_id'])->whereMonth('created_at', now())->first();
            if (!$playerMonth) {
                $playerMonth = PlayerMonth::create($join);
            } else {
                $test = collect($join)->except(['match_id', 'id', 'user_id'])->toArray();
                $playerMonth->incrementEach($test);
            }
            $points = ($playerMonth->goals * 3) + ($playerMonth->assists * 2) + ($playerMonth->goal_keeper * 1);
            $playerMonth->update(['points' => $points]);
        }
        $match->update($request->validated() + ['is_finished' => 1]);
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
