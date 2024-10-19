<?php

namespace App\Http\Controllers\Players;

use App\Http\Controllers\Controller;
use App\Http\Requests\Games\JoinRequest;
use App\Models\Join;
use App\Models\MatchGame;

class JoinController extends Controller
{
    /**
     * Index a newly created resource in storage.
     */
    public function index($match_id, $team_color)
    {
        $replacedTeam = Join::where('match_id', $match_id)->where('team_color', '!=', $team_color)->paginate(10);
        return contentResponse($replacedTeam);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JoinRequest $request)
    {
        $joining = Join::create(array_merge($request->validated(), ['user_id' => auth()->id()]));
        $match = MatchGame::with('staduim')->firstWhere('id', $request->validated('match_id'));
        if ($match->joining_numbers >= $match->staduim->players_number) {
            $joining->update(['status' => 'waiting']);
        }
        $match->increment('joining_numbers');
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
        $join->forceDelete();
        $match = MatchGame::with('staduim')->firstWhere('id', $join->match_id)->where('joining_numbers', '!=', 0)->decrement('joining_numbers');
        return messageResponse('User leave match successfully');
    }
}
