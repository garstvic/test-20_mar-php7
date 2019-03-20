<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// List of houses
Route::get('houses', 'HouseController@index');

// List of single house
Route::get('house/{id}', 'HouseController@show');

// List of founded houses
Route::get('search', 'HouseController@search');
Route::post('search', 'HouseController@search');
