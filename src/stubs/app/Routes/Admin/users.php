<?php

Route::group(['prefix' => 'v1/admin/users'], function () {
    Route::get('/', 'UsersController@getUsers');
    Route::get('/{user}', 'UsersController@getUserProfile');
    Route::put('/{user}', 'UsersController@updateUser');
    Route::post('/{user}', 'UsersController@updatePhoto');
    Route::post('/', 'UsersController@createUser')->middleware('auth.has-root-permissions');
    Route::delete('/{user}', 'UsersController@deleteUser')->middleware('auth.has-root-permissions');
});
