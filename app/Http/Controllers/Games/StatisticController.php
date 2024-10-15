<?php

namespace App\Http\Controllers\Games;

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
        // Use lazy loading instead of eager loading if you don't need all related data
        $statistics = Statistic::with('user')->get();
        return contentResponse($statistics);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StatisticRequest $request)
    {
        DB::transaction(function () use ($request) {
            // Create the statistic first
            $statistic = Statistic::create($request->validated());

            // Update PlayerMonth
            $player_month = PlayerMonth::firstOrCreate(['user_id' => $request->user_id]);
            $player_month->increment('goals', $request->goals ?? 0);
            $player_month->increment('assists', $request->assists ?? 0);
            $player_month->increment('goal_keeper', $request->goal_keeper ?? 0);

            // Calculate points
            $points = ($request->goals ?? 0) * 3 + ($request->assists ?? 0) * 1 + ($request->goal_keeper ?? 0);
            $player_month->increment('points', $points);
        });

        return messageResponse();
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
            $player_month = PlayerMonth::firstWhere('user_id', $request->user_id);

            if ($player_month) {
                // Calculate new values for increments
                $newGoals = ($request->goals ?? 0) - $statistic->goals;
                $newAssists = ($request->assists ?? 0) - $statistic->assists;
                $newGoalKeeper = ($request->goal_keeper ?? 0) - $statistic->goal_keeper;

                // Increment only if there's a change
                if ($newGoals !== 0) {
                    $player_month->increment('goals', $newGoals);
                }
                if ($newAssists !== 0) {
                    $player_month->increment('assists', $newAssists);
                }
                if ($newGoalKeeper !== 0) {
                    $player_month->increment('goal_keeper', $newGoalKeeper);
                }

                // Update points
                $points = $newGoals * 3 + $newAssists * 1 + $newGoalKeeper;
                $player_month->increment('points', $points);
            }

            // Update statistic
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
