<?php

use App\Http\Controllers\Optimization\CacheController;
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
        Route::post('register', 'Auth\AuthController@register');
        Route::post('/password/forget', 'Auth\AuthController@forgetPassowrd')->name('password.email');
        Route::post('/password/reset', 'Auth\AuthController@resetPassword')->name('password.reset');
    });

    // Authorizations
    Route::group(['middleware' => 'auth:api'], function () {
        // About User
        Route::group(['prefix' => 'auth'], function () {
            Route::post('me', 'Auth\AuthController@me');
            Route::post('refresh', 'Auth\AuthController@refresh');
            Route::post('logout', 'Auth\AuthController@logout');
            Route::post('blocked/{user}', 'Auth\AuthController@blockedUser');
        });
    });
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
Route::apiResource('matches', 'Games\MatchController');
Route::post('matches/finish/{match}', 'Games\MatchController@finishMatch');

// Joins
Route::apiResource('joins', 'Games\JoinController');
Route::get('joins/team/{match_id}/{team_color}', 'Games\JoinController@index')->name('joins.index');
Route::put('joins/replace/{player_1}/{player_2}', 'Games\JoinController@update')->name('joins.update');

// Ads
Route::apiResource('ads', 'Ads\AdsController');

// Statistics
Route::apiResource('statistics', 'Games\StatisticController');

// Statistics
Route::get('player/months/{date}', 'Games\PlayerMonthController@playerMonths');
