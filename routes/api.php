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
//
//Route::middleware(['auth:api'])->group(function () {
//    Route::get('/users', 'UserController@index');
//});

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

Route::middleware(['cors'])->group(function () {
    Route::get('/users', 'UserController@index');
});

Route::middleware(['cors'])->group(function () {
    Route::post('/signup', 'UserController@store');
});

Route::group(['middleware' => 'cors', 'prefix' => 'services'], function ($router) {
    Route::get('/categories', 'CategoryController@index');
    Route::get('/categories/{id}', 'CategoryController@show');
    Route::post('/categories', 'CategoryController@store');
    Route::delete('/categories/{id}', 'CategoryController@destroy');
    Route::put('/categories/{id}', 'CategoryController@update');

    Route::get('/offers', 'OfferController@index');
    Route::get('/offers/{id}', 'OfferController@show');
    Route::post('/offers', 'OfferController@store');
    Route::put('/{id}', 'ServiceController@update');
    Route::delete('/offers/{id}', 'OfferController@destroy');


    Route::post('/offers/solicitations', 'SolicitationController@store');


    Route::get('/', 'ServiceController@index');
    Route::get('/{id}', 'ServiceController@show');
    Route::post('/', 'ServiceController@store');
    Route::put('/{id}', 'ServiceController@update');
    Route::delete('/{id}', 'ServiceController@destroy');


//    Route::get('/services/{categoryid?}/{title?}', 'ServiceController@show');
//    Route::post('/services', 'ServiceController@store');
//    Route::put('/services/{id}', 'ServiceController@update');
//    Route::delete('/services/{id}', 'ServiceController@destroy');


});

