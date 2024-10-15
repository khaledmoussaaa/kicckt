<?php

namespace App\Http\Controllers\Games;

use App\Http\Controllers\Controller;
use App\Http\Requests\Games\JoinRequest;
use App\Models\Join;

class JoinController extends Controller
{
    public function index($match_id, $team_color)
    {
        $replacedTeam = Join::where('match_id', $match_id)->where('team_color', '!=', $team_color)->get();
        return contentResponse($replacedTeam);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JoinRequest $request)
    {
        // Join in new match
        $joiningMatch = Join::create(array_merge($request->validated(), ['user_id' => auth()->id()]));
        return messageResponse();
    }

    public function update(Join $player_1, Join $player_2)
    {
        $team_color = $player_1->team_color;
        $player_1->update(['team_color' => $player_2->team_color]);
        $player_2->update(['team_color' => $team_color]);
        return messageResponse();
    }

    /**
     * Delete the specified resource from storage.
     */
    public function destroy(Join $join)
    {
        // Delete Join
        $join->forceDelete();
        return messageResponse('User leave match successfully');
    }
}
