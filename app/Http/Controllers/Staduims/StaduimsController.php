<?php

namespace App\Http\Controllers\Staduims;

use App\Http\Controllers\Controller;
use App\Http\Requests\Stduims\StduimRequest;
use App\Models\Staduim;

class StaduimsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Show all staduims
        $staduims = Staduim::get();
        return contentResponse($staduims);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StduimRequest $request)
    {
        // Create new staduim
        $staduim = Staduim::create($request->validated());
        if($request->hasFile('media')){
            $staduim->addMediaFromRequest('media')->toMediaCollection('staduims');
        }
        return messageResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(Staduim $staduim)
    {
        // Show staduim
        $staduim->getFirstMedia('staduims');
        return contentResponse($staduim);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Staduim $staduim)
    {
        // Edit staduim
        return contentResponse($staduim);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(StduimRequest $request, Staduim $staduim)
    {
        // Update staduim
        $staduim->update($request->validated());
        if($request->hasFile('media')){
            $staduim->addMediaFromRequest('media')->toMediaCollection('staduims');
        }
        return messageResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Staduim $staduim)
    {
        // Delete staduim
        $staduim->forceDelete();
        return messageResponse();
    }
}
