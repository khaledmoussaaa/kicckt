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
        $ads = Ads::with('media')->get();
        return contentResponse($ads);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdsRequest $request)
    {
        $ad = Ads::create($request->validated());
        add_media($ad, $request, 'ads');
        return messageResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(Ads $ads)
    {
        return contentResponse($ads->load('media'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdsRequest $request, Ads $ad)
    {
        $ad->update($request->validated());
        add_media($ad, $request, 'ads');
        return messageResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ads $ad)
    {
        $ad->forceDelete();
        return messageResponse();
    }
}
