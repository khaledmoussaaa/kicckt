<?php

namespace App\Http\Controllers\Players;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;

class PlayerMonthController extends Controller
{
    public function playerMonths($date, $type)
    {
        // Parse the provided date to ensure correct format
        $date = Carbon::parse($date);

        // Retrieve users with their player_months for the specified month
        $players = User::with('media')->withWhereHas('player_month', function ($query) use ($date) {
            $query->whereMonth('created_at', $date);
        })->get();

        // If no players have player_months for the specified month, get all users
        if ($players->isEmpty()) {
            $playerMonths = User::with(['media', 'player_month' => function ($query) use ($date) {
                $query->whereMonth('created_at', $date);
            }])->WhereHasRole('user')->get()->sortBy('name')->values()->flatten();
        } else {
            // Sort players by the specified dynamic field (goals, assists, points)
            $playerMonths = $players->sortByDesc(function ($user) use ($type) {
                // Check if the player has a player_month record for the given month
                if ($user->player_month) {
                    // Access the specific type field (goals, assists, points)
                    return $user->player_month->$type;  // Access dynamically based on $type
                }
                return 0; // If no player_month exists, return 0 for sorting
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

        return contentResponse($topUsers);
    }
}
