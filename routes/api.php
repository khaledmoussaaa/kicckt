<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'api'], function () {
    /*
    |--------------------------------------------------------------------------
    | Authuntication API Routes
    |--------------------------------------------------------------------------
    */
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', 'Auth\AuthController@login');
        Route::post('/password/forget', 'Auth\AuthController@forgetPassowrd')->name('password.email');
        Route::post('/password/reset', 'Auth\AuthController@resetPassword')->name('password.reset');
    });

    /*
    |--------------------------------------------------------------------------
    | Authorizations API Routes
    |--------------------------------------------------------------------------
    */
    Route::group(['middleware' => 'auth:api'], function () {
        Route::group(['prefix' => 'auth'], function () {
            Route::post('profile', 'Auth\AuthController@profile');
            Route::post('me', 'Auth\AuthController@me');
            Route::post('refresh', 'Auth\AuthController@refresh');
            Route::post('logout', 'Auth\AuthController@logout');
            Route::post('block', 'Auth\AuthController@blocked');
        });

        // Users
        Route::apiResource('users', 'Users\UserController');
        Route::post('users/{user}', 'Users\UserController@update')->name('users.update');;

        // Staduims
        Route::apiResource('staduims', 'Staduims\StaduimsController');
        Route::post('staduims/{staduim}', 'Staduims\StaduimsController@update')->name('staduims.update');;

        // Matches
        Route::apiResource('matches', 'Matches\MatchController');
        Route::post('matches/finish/match/{match}', 'Matches\MatchController@finish');
        Route::get('previous/matches', 'Matches\MatchController@pervious');

        // Joins
        Route::apiResource('joins', 'Joins\JoinController');
        Route::put('joins/replace/{join_1}/{join_2}', 'Joins\JoinController@replace')->name('joins.replace');

        // Players
        Route::get('player/months/{date}/{type}', 'Players\PlayerMonthController@playerMonths');

        // Prizes
        Route::apiResource('prizes', 'Prizes\PrizeController');

        // Ads
        Route::apiResource('ads', 'Ads\AdsController');
        Route::post('ads/{ad}', 'Ads\AdsController@update')->name('ads.update');

        // Date
        Route::get('date', function () {
            return contentResponse(['Date' => now()->format('d-m-Y h:i A')]);
        });
    });
});
