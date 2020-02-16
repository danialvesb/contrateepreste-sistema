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


Route::middleware(['cors'])->group(function () {
    //Rotas raizes devem ser colocadas depois pois evita que as mesmas vão substituam as rotas do subdomínio que possuem o mesmo caminho de URI.

    Route::get('/services/categories', 'CategoryController@index');
    Route::get('/services/categories/{id}', 'CategoryController@show');
    Route::post('/services/categories', 'CategoryController@store');
    Route::put('/services/ /{id}', 'CategoryController@update');
    Route::delete('/services/categories/{id}', 'CategoryController@destroy');

    Route::get('/services', 'ServiceController@index');
    Route::get('/services/{categoryid?}/{title?}', 'ServiceController@show');
    Route::post('/services', 'ServiceController@store');
    Route::put('/services/{id}', 'ServiceController@update');
    Route::delete('/services/{id}', 'ServiceController@destroy');


});

