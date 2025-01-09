<?php

namespace App\Http\Controllers\Players;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Mail\Mailables\Content;

class PlayerMonthController extends Controller
{
    public function playerMonths($date, $type)
    {
        // Parse the provided date to ensure correct format
        $date = Carbon::parse($date);

        // Retrieve users with their player_months for the specified month
        $players = User::with('media')->with('player_month', function ($query) use ($date) {
            $query->whereMonth('created_at', $date);
        })->WhereHasRole('user')->get();

        // Sort players by player_month (goals, assists, points) or by name alphabetically
        $playerMonths = $players->sortByDesc(function ($user) use ($type) {
            // If player_month exists, return the type field value (goals, assists, points)
            if ($user->player_month) {
                return $user->player_month->$type;
            }

            // If no player_month exists, return null to push them to the bottom
            return null;
        })->sortBy(function ($user) {
            // If player_month is null, sort by name alphabetically
            return $user->player_month ? null : $user->name;
        })->values();


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
        if ((isset($authUser)) && (!$authUser || $authUser->rank > 7)) {
            $topUsers->push($authUser);
        }

        // Reset the keys of the collection after the push
        $topUsers = $topUsers->values();

        return contentResponse($topUsers);
    }
}
