<?php

namespace App\Http\Controllers\Ads;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ads\AdsRequest;
use App\Models\Ads;

class AdsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ads = Ads::get();
        return contentResponse($ads);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdsRequest $request)
    {
        $ads = Ads::create($request->validated());
        return messageResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(Ads $ads)
    {
        return contentResponse($ads);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdsRequest $request, Ads $ads)
    {
        $ads->update($request->validated());
        return messageResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ads $ads)
    {
        $ads->forceDelete();
        return messageResponse();
    }
}