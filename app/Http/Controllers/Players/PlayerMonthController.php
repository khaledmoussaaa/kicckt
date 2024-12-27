<?php

namespace App\Http\Controllers\Players;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;

class PlayerMonthController extends Controller
{
    public function playerMonths($date, $type)
    {
        $date = Carbon::parse($date);

        // Retrieve users with their player_months for the specified month
        $players = User::whereHas('player_months', function ($query) use ($date) {
            $query->whereMonth('created_at', $date);
        })->get();

        // Check if there are no player_months for the month
        if ($players->isEmpty()) {
            $playerMonths = User::with(['player_months' =>  function ($query) use ($date) {
                $query->whereMonth('created_at', $date);
            }])->get()->sortBy('name')->values();
        } else {
            $playerMonths = $players->load('player_months')->sortByDesc(function ($user) use ($type) {
                return $user->player_months->sum($type);
            })->values();
        }

        // Transform to assign ranks to users
        $topPlayers = $playerMonths->transform(function ($user, $index) {
            $user->rank = $index + 1; // Rank starts at 1
            return $user;
        });

        // Get the authenticated user's rank
        $authUser = $topPlayers->firstWhere('id', auth()->id());

        // Get the top 7 users
        $topUsers = $topPlayers->take(7);

        // Check if the authenticated user is already in the top 7
        if (!$authUser || $authUser->rank > 7) {
            $topUsers->push($authUser);
        }

        // Reset the keys of the collection after the push
        $topUsers = $topUsers->values();

        return contentResponse($topUsers->load('media'));
    }
}
