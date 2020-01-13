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

Route::middleware('auth:api', 'cors')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/services.json', 'ServiceController@index');
Route::get('/services/{id}.json', 'ServiceController@show');
Route::post('/services.json', 'ServiceController@store');
Route::put('/services/{id}.json', 'ServiceController@update');
Route::delete('/services/{id}.json', 'ServiceController@destroy');


