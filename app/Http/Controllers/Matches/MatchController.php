<?php

namespace App\Http\Controllers\Matches;

use App\Http\Controllers\Controller;
use App\Http\Requests\Games\MatchRequest;
use App\Models\MatchGame;
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
        $matches = MatchGame::with(['joins.players.media'])->whereDate('date', $date)->paginate(10);
        $matches->getCollection()->transform(function ($match) {
            $match->joins = $match->joins->transform(function ($join) {
                return $join->players;
            });
            return $match->load('staduim');
        });
        return contentResponse($matches);
    }

    /**
     * Display a listing of the resource.
     */
    public function pervious()
    {
        $matches = MatchGame::with(['joins.players.media'])->whereHas('joins.players', function ($query) {
            $query->where('user_id', auth_id());
        })->paginate(10);

        $matches->getCollection()->transform(function ($match) {
            $match->joins = $match->joins->transform(function ($join) {
                return $join->players;
            });
            return $match->load('staduim');
        });
        return contentResponse($matches);
    }

    /**
     * Display the specified resource.
     */
    public function show(MatchGame $match)
    {
        $match = $match->load('joins.players.media');
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
     * Delete the specified resource from storage.
     */
    public function destroy(MatchGame $match)
    {
        $match->forceDelete();
        return messageResponse();
    }
}
