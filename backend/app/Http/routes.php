<?php

Route::get('/info', 'Auth\AuthController@info');
Route::get('/logout', 'Auth\AuthController@logout');
Route::get('/login/meli', 'Auth\AuthController@loginProvider');

Route::get('/notificacoes/{id}', 'NotificationController@show');
Route::post('/notificacoes', 'NotificationController@store');

Route::group(['middleware' => 'auth'], function(){

    Route::get('/', function(){ return view('index'); });

    Route::get('/auth', 'Auth\AuthController@get');

    // Resources
    Route::resource('/usuarios', 'UserController');
    Route::post('/blockUser', 'UserController@block');
    Route::delete('/unlockUser/{blocked}', 'UserController@unlock');

    Route::resource('/tarefas', 'TaskController');

    Route::get('/anuncios', 'AdvertController@index');

});