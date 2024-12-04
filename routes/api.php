<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Guest API Routes
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => 'api'], function () {
    // Authuntication
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', 'Auth\AuthController@login');
        Route::post('/password/forget', 'Auth\AuthController@forgetPassowrd')->name('password.email');
        Route::post('/password/reset', 'Auth\AuthController@resetPassword')->name('password.reset');
    });

    // Authorizations
    Route::group(['middleware' => 'auth:api'], function () {
        // About User
        Route::group(['prefix' => 'auth'], function () {
            Route::post('profile', 'Auth\AuthController@profile');
            Route::post('me', 'Auth\AuthController@me');
            Route::post('refresh', 'Auth\AuthController@refresh');
            Route::post('logout', 'Auth\AuthController@logout');
            Route::post('block', 'Auth\AuthController@blocked');
        });

        /*
        |--------------------------------------------------------------------------
        | Admin API Routes
        |--------------------------------------------------------------------------
        */
        // Staduims
        Route::apiResource('staduims', 'Staduims\StaduimsController');
        Route::post('staduims/{staduim}', 'Staduims\StaduimsController@update')->name('staduims.update');;

        /*
        |--------------------------------------------------------------------------
        | User API Routes
        |--------------------------------------------------------------------------
        */
        // Matches
        Route::apiResource('matches', 'Matches\MatchController');
        Route::post('matches/start/finish', 'Matches\FinishMatchController@startFinishMatch');
        Route::post('matches/end/finish/{match}', 'Matches\FinishMatchController@endFinishMatch');

        // Joins
        Route::apiResource('joins', 'Players\JoinController');
        Route::get('joins/team/{match_id}/{team_color}', 'Players\JoinController@index')->name('joins.index');
        Route::put('joins/replace/{player_1}/{player_2}', 'Players\JoinController@update')->name('joins.update');

        // Players
        Route::get('player/months/{date}/{type}', 'Players\PlayerMonthController@playerMonths');
        Route::apiResource('statistics', 'Matches\StatisticController');

        // Ads
        Route::apiResource('ads', 'Ads\AdsController');
    });
});
