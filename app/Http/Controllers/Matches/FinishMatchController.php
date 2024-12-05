<?php

namespace App\Http\Controllers\Matches;

use App\Http\Controllers\Controller;
use App\Http\Requests\Games\EndFinishMatchRequest;
use App\Http\Requests\Games\StartFinishMatchRequest;
use App\Models\Join;
use App\Models\MatchGame;
use App\Models\Statistic;

class FinishMatchController extends Controller
{
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
}
