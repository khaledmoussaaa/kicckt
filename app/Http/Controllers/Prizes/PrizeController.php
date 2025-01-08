<?php

namespace App\Http\Controllers\Prizes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Players\PlayerPrizesRequest;
use App\Models\PlayerMonth;
use App\Models\Prize;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PrizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $date = Carbon::now()->lastOfMonth();
        $currentPlayer = auth_user()->load(['media', 'player_months' => function ($query) use ($date) {
            $query->whereMonth('created_at', $date);
        }]);
        $playerOfPoints = PlayerMonth::with('user.media')->whereMonth('created_at', $date)->orderByDesc('points')->first();
        $playerOfGoals = PlayerMonth::with('user.media')->whereMonth('created_at', $date)->orderByDesc('goals')->first();
        $playerOfAssists = PlayerMonth::with('user.media')->whereMonth('created_at', $date)->orderByDesc('assists')->first();
        $playerOfGoalKeeper = PlayerMonth::with('user.media')->whereMonth('created_at', $date)->orderByDesc('goal_keeper')->first();
        $playerOfLastMonth = Prize::with(['media', 'user.media'])->get();

        $prizes = [
            'current_player' => $currentPlayer,
            'player_top_points' => $playerOfPoints,
            'player_top_goals' => $playerOfGoals,
            'player_top_assists' => $playerOfAssists,
            'player_top_goal_keeper' => $playerOfGoalKeeper,
            'player_last_month' => $playerOfLastMonth,
        ];

        return contentResponse($prizes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PlayerPrizesRequest  $request)
    {
        $prize = Prize::updateOrCreate($request->safe()->only('user_id'));
        if ($request->has('media')) {
            $prize->addMediaFromRequest('media')->toMediaCollection('beautiful_goal');
        }
        return messageResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
