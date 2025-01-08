<?php

namespace App\Http\Controllers\Staduims;

use App\Http\Controllers\Controller;
use App\Http\Requests\Stduims\StduimRequest;
use App\Models\Staduim;

class StaduimsController extends Controller
{
    /**
     * Index a newly created resource in storage.
     */
    public function index()
    {
        $staduims = Staduim::get();
        return contentResponse($staduims->load('media'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StduimRequest $request)
    {
        $staduim = Staduim::create($request->validated());
        add_media($staduim, $request, 'staduims');
        return messageResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(Staduim $staduim)
    {
        return contentResponse($staduim->load('media'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StduimRequest $request, Staduim $staduim)
    {
        $staduim->update($request->validated());
        add_media($staduim, $request, 'staduims');
        return messageResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Staduim $staduim)
    {
        $staduim->forceDelete();
        return messageResponse();
    }
}
