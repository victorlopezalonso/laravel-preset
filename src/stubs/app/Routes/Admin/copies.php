<?php

Route::group(['prefix' => 'v1/admin/copies'], function () {
    Route::get('/', 'CopiesController@get');
    Route::get('/params', 'CopiesController@getParameters');
    Route::get('/admin', 'CopiesController@getAdminCopies');
    Route::put('/{copy}', 'CopiesController@update');
    Route::post('/', 'CopiesController@create');
    Route::delete('/{copy}', 'CopiesController@delete');
    Route::get('/excel', 'CopiesController@exportExcel');
    Route::post('/excel', 'CopiesController@importFromExcel');
});
