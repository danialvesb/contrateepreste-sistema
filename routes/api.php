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

Route::middleware(['cors'])->group(function () {
    //Rotas raizes devem ser colocadas depois pois evita que as mesmas vão substituam as rotas do subdomínio que possuem o mesmo caminho de URI.

    Route::get('/services/categories', 'CategoryController@index');
    Route::get('/services/categories/{id}', 'CategoryController@show');
    Route::post('/services/categories', 'CategoryController@store');
    Route::put('/services/ /{id}', 'CategoryController@update');
    Route::delete('/services/categories/{id}', 'CategoryController@destroy');

    Route::get('/services/offers', 'OfferController@index');
    Route::get('/services/offers/{id}', 'OfferController@show');
    Route::post('/services/offers', 'OfferController@store');
//    Route::put('/services/{id}', 'ServiceController@update');
    Route::delete('/services/offers/{id}', 'OfferController@destroy');


    Route::post('/services/offers/solicitations', 'SolicitationController@store');


    Route::get('/services', 'ServiceController@index');
    Route::get('/services/{id}', 'ServiceController@show');
    Route::post('/services', 'ServiceController@store');
    Route::put('/services/{id}', 'ServiceController@update');
    Route::delete('/services/{id}', 'ServiceController@destroy');


//    Route::get('/services/{categoryid?}/{title?}', 'ServiceController@show');
//    Route::post('/services', 'ServiceController@store');
//    Route::put('/services/{id}', 'ServiceController@update');
//    Route::delete('/services/{id}', 'ServiceController@destroy');


});

