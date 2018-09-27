<?php

Route::group(['prefix' => 'v1/admin/stats'], function () {
    Route::get('/', 'StatsController@getStats');
});