<?php

Route::group(['prefix' => 'v1/admin/config', 'middleware' => 'auth.has-root-permissions'], function () {

    Route::get('/', 'ConfigController@getConfig');

    Route::get('/languages', 'ConfigController@getLanguages');

    Route::put('/', 'ConfigController@update');

    Route::post('/deploy', 'ConfigController@deploy');
});