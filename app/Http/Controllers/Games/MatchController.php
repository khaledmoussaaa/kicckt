<?php

namespace App\Http\Controllers\Games;

use App\Http\Controllers\Controller;
use App\Http\Requests\Games\FinishMatchRequest;
use App\Http\Requests\Games\MatchRequest;
use App\Models\MatchGame;

class MatchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all matches
        $matches = MatchGame::get();
        return contentResponse($matches);
    }

    /**
     * Display the specified resource.
     */
    public function show(MatchGame $match)
    {
        // Show match
        $match = $match->load('staduim', 'joins.players.media.getUrl');
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
        // Create new match
        $match = MatchGame::create($request->validated());
        return messageResponse();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MatchRequest $request, MatchGame $match)
    {
        // Update match
        $match->update($request->validated());
        return messageResponse();
    }

    public function finishMatch(FinishMatchRequest $request, MatchGame $match)
    {
        $match->update($request->validated());
        return messageResponse();
    }

    /**
     * Delete the specified resource from storage.
     */
    public function destroy(MatchGame $match)
    {
        // Delete Match
        $match->forceDelete();
        return messageResponse();
    }
}
