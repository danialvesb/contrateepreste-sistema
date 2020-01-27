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


Route::get('/services', 'ServiceController@index');
Route::get('/services/{id}', 'ServiceController@show');
Route::post('/services', 'ServiceController@store');
Route::put('/services/{id}', 'ServiceController@update');
Route::delete('/services/{id}', 'ServiceController@destroy');

Route::get('/services/categories', 'CategoryController@index');
Route::get('/services/categories/{id}', 'CategoryController@show');
Route::post('/services/categories', 'CategoryController@store');
Route::put('/services/categories/{id}', 'CategoryController@update');
Route::delete('/services/categories/{id}', 'CategoryController@destroy');
