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

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('/signup', 'UserController@store');
    Route::post('/login', 'AuthController@login');
    Route::post('/logout', 'AuthController@logout');
    Route::post('/refresh', 'AuthController@refresh');
    Route::post('/me', 'AuthController@me');
});

Route::group(['middleware' => ['cors', 'apijwt'], 'prefix' => 'users'], function ($router) {
    Route::get('/groups', 'GroupController@index');
    Route::get('/', 'UserController@index');
    Route::get('/{id}', 'UserController@show');
});

Route::group(['middleware' => ['cors', 'apijwt'], 'prefix' => 'services/offers'], function ($router) {
    Route::get('/solicitations', 'SolicitationController@index');
    Route::post('/solicitations', 'SolicitationController@store');
});

Route::group(['middleware'=> ['cors', 'apijwt'], 'prefix'=>'services/offers'], function ($router) {
    Route::post('/calleds/accept/{id}', 'SolicitationController@acceptCalled');
    Route::post('/calleds/end/{id}', 'SolicitationController@endCalled');
    Route::post('/calleds/close/{id}', 'SolicitationController@closeCalled');
    Route::post('/calleds/refuse/{id}', 'SolicitationController@refuseCalled');
    Route::get('/calleds', 'SolicitationController@calleds');

});

Route::group(['middleware' => 'cors', 'prefix' => 'services/offers'], function ($router) {
    Route::get('/', 'OfferController@index');
    Route::get('/{id}', 'OfferController@show');
    Route::post('/', 'OfferController@store');
    Route::delete('/{id}', 'OfferController@destroy');
});

Route::group(['middleware' => 'cors', 'prefix' => 'services/categories'], function ($router) {
    Route::get('/', 'CategoryController@index');
    Route::get('//{id}', 'CategoryController@show');
    Route::post('/', 'CategoryController@store');
    Route::delete('/{id}', 'CategoryController@destroy');
    Route::put('/{id}', 'CategoryController@update');
});

Route::group(['middleware' => ['cors', 'apijwt'], 'prefix' => 'services'], function ($router) {
    Route::get('/', 'ServiceController@index');
    Route::get('/details', 'ServiceController@index');
    Route::put('/{id}', 'ServiceController@update');
    Route::get('/{id}', 'ServiceController@show');
    Route::post('/', 'ServiceController@store');
    Route::put('/{id}', 'ServiceController@update');
    Route::delete('/{id}', 'ServiceController@destroy');
});
