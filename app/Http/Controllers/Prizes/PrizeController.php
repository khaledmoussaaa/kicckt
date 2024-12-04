<?php

namespace App\Http\Controllers\Prizes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Players\PlayerPrizesRequest;
use App\Models\Prize;
use Illuminate\Http\Request;

class PrizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
