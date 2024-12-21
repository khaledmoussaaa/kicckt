<?php

namespace App\Http\Controllers\Matches;

use App\Http\Controllers\Controller;
use App\Http\Requests\Games\EndFinishMatchRequest;
use App\Http\Requests\Games\MatchRequest;
use App\Http\Requests\Games\StartFinishMatchRequest;
use App\Models\Join;
use App\Models\MatchGame;
use App\Models\Statistic;
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
        $userId = auth_id();
        $matches = MatchGame::getMatches(null, true, $userId);
        return contentResponse($matches);
    }

    /**
     * Display the specified resource.
     */
    public function show(MatchGame $match)
    {
        $match = $match->load('staduim.media', 'joins.players.media');
        $match->joins->transform(function ($join) {
            $join->players->team_color = $join->team_color;
            $join->players->join_id = $join->id;
            return $join->players;
        });
        return contentResponse($match);
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
     * Start Finish Match.
     */
    public function startFinishMatch(StartFinishMatchRequest $request)
    {
        $joins = Join::where('match_id', $request->match_id)->get();
        foreach ($joins as $join) {
            $statistic = Statistic::create(array_merge($request->validated(), ['user_id' => $join->user_id]));
        }
        $match = MatchGame::find($request->validated('match_id'))->update(['is_finished' => true]);
        return messageResponse();
    }

    /**
     * End Finish Match.
     */
    public function endFinishMatch(EndFinishMatchRequest $request)
    {
        $match = MatchGame::find($request->validated('match_id'))->update($request->validated());
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
