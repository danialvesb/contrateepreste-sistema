<?php

Route::resource('files', 'FileController');

Route::group(['prefix' => 'auth'], function ($router) {
    Route::post('/signup', 'UserController@store');
});

Route::group(['prefix' => 'chat', 'middleware' => 'apijwt'], function ($router) {
    Route::get('/', 'ChatsController@index');
    Route::get('messages/{solicitation}', 'ChatsController@fetchMessages');
    Route::post('messages', 'ChatsController@sendMessage');
});


Route::group(['prefix' => 'me'], function ($router) {
    Route::get('/_image/profile/{file_name}', 'ManagerProfileMeController@getImgProfile');

    Route::group(['middleware' => 'apijwt'], function ($router) {
        Route::post('/update/photo', 'ManagerProfileMeController@updatePhotoMobile');
        Route::put('/update', 'ManagerProfileMeController@update');
        Route::post('/update', 'ManagerProfileMeController@update');
    });
});

Route::group(['middleware' => ['api'], 'prefix' => 'auth'], function ($router) {
    Route::post('/login', 'AuthController@login');
    Route::post('/logout', 'AuthController@logout');
    Route::post('/refresh', 'AuthController@refresh');
    Route::post('/me', 'AuthController@me');
});

Route::group(['prefix' => 'users'], function ($router) {
    Route::get('/groups', 'GroupController@index');
});

Route::group(['middleware' => ['apijwt'], 'prefix' => 'users'], function ($router) {
    Route::get('/{id}', 'UserController@show');
    Route::get('/', 'UserController@index');
});

Route::group(['middleware' => ['apijwt'], 'prefix' => 'services/offers'], function ($router) {
    Route::get('/solicitations', 'SolicitationController@index');
    Route::post('/solicitations', 'SolicitationController@store');
});

Route::group(['middleware'=> ['apijwt'], 'prefix'=>'services/offers'], function ($router) {
    Route::post('/calleds/accept/{id}', 'SolicitationController@acceptCalled');
    Route::post('/calleds/end/{id}', 'SolicitationController@endCalled');
    Route::post('/calleds/close/{id}', 'SolicitationController@closeCalled');
    Route::post('/calleds/refuse/{id}', 'SolicitationController@refuseCalled');
    Route::get('/calleds/management', 'SolicitationController@calledsManagement');
    Route::get('/calleds', 'SolicitationController@calleds');

});

Route::group(['prefix' => 'services/offers'], function ($router) {
    Route::get('/', 'OfferController@index');
    Route::get('/{id}', 'OfferController@show');
    Route::post('/', 'OfferController@store');
    Route::delete('/{id}', 'OfferController@destroy');
});

Route::group(['prefix' => 'services/categories'], function ($router) {
    Route::get('/', 'CategoryController@index');
    Route::get('//{id}', 'CategoryController@show');
    Route::post('/', 'CategoryController@store');
    Route::delete('/{id}', 'CategoryController@destroy');
    Route::put('/{id}', 'CategoryController@update');
});

Route::group(['middleware' => ['apijwt'], 'prefix' => 'services'], function ($router) {
    Route::get('/', 'ServiceController@index');
    Route::get('/details', 'ServiceController@index');
    Route::put('/{id}', 'ServiceController@update');
    Route::get('/{id}', 'ServiceController@show');
    Route::post('/', 'ServiceController@store');
    Route::put('/{id}', 'ServiceController@update');
    Route::delete('/{id}', 'ServiceController@destroy');
});
