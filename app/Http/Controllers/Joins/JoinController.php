<?php

namespace App\Http\Controllers\Joins;

use App\Events\PlayerJoin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Joins\JoinRequest;
use App\Http\Requests\Joins\JoinUpdateRequest;
use App\Models\Join;
use Illuminate\Http\Request;

class JoinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $joins = Join::matchScope($request)->paginate(10);
        return contentResponse($joins->load('user.media'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JoinRequest $request)
    {
        $join = Join::create($request->validated() + ['user_id' => auth_id()]);
        $join->match()->increment('joining_numbers');
        broadcast(new PlayerJoin($join, 'join'));
        return contentResponse($join);
    }

    /**
     * Display the specified resource.
     */
    public function show(Join $join)
    {
        return contentResponse($join);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JoinUpdateRequest $request, Join $join)
    {
        return messageResponse();
    }

    /**
     * Update the specified resource in storage.
     */
    public function replace(Join $join_1, Join $join_2)
    {
        $team_color = $join_1->team_color;
        $team_position = $join_1->position;
        $join_1->update(['team_color' => $join_2->team_color, 'position' => $join_2->position]);
        $join_2->update(['team_color' => $team_color, 'position' => $team_position]);
        return messageResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Join $join)
    {
        broadcast(new PlayerJoin($join, 'unjoin'));
        $join->match()->decrement('joining_numbers');
        $join->forceDelete();
        return messageResponse();
    }

    public function test()
    {
        broadcast(new PlayerJoin());
        return messageResponse();
    }
}
