<?php

Route::group(['prefix' => 'v1/admin/users'], function () {
    Route::get('/', 'UsersController@getUsers');
    Route::put('/{user}', 'UsersController@updateUser');
    Route::post('/', 'UsersController@createUser')->middleware('auth.has-root-permissions');
    Route::delete('/{user}', 'UsersController@deleteUser')->middleware('auth.has-root-permissions');
});