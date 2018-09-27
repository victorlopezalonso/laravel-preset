<?php

Route::group(['prefix' => 'v1/admin/copies'], function () {

    Route::get('/', 'CopiesController@get');
    Route::put('/{copy}', 'CopiesController@update');
    Route::post('/', 'CopiesController@create');
    Route::delete('/{copy}', 'CopiesController@delete');
    Route::get('/excel', 'CopiesController@exportExcel');
    Route::post('/excel', 'CopiesController@importFromExcel');

});