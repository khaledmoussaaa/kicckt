<?php

namespace App\Http\Controllers\Matches;

use App\Http\Controllers\Controller;
use App\Http\Requests\Games\StatisticRequest;
use App\Models\PlayerMonth;
use App\Models\Statistic;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $statistics = Statistic::with('user')->paginate(10);
        return contentResponse($statistics);
    }

    /**
     * Display the specified resource.
     */
    public function show(Statistic $statistic)
    {
        return contentResponse($statistic);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StatisticRequest $request, Statistic $statistic)
    {
        DB::transaction(function () use ($request, $statistic) {
            $player_month = PlayerMonth::firstOrCreate(['user_id' => $request->user_id]);

            if ($player_month) {
                $newGoals = ($request->goals ?? 0) - $player_month->goals;
                $newAssists = ($request->assists ?? 0) - $player_month->assists;
                $newGoalKeeper = ($request->goal_keeper ?? 0) - $player_month->goal_keeper;

                if ($newGoals !== 0) {
                    $player_month->increment('goals', $newGoals);
                }
                if ($newAssists !== 0) {
                    $player_month->increment('assists', $newAssists);
                }
                if ($newGoalKeeper !== 0) {
                    $player_month->increment('goal_keeper', $newGoalKeeper);
                }

                $points = $newGoals * 3 + $newAssists * 1 + $newGoalKeeper;
                $player_month->increment('points', $points);
            }

            $statistic->update($request->validated());
        });

        return messageResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Statistic $statistic)
    {
        $statistic->forceDelete();
        return messageResponse();
    }
}
