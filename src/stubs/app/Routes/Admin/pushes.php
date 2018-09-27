<?php

Route::group(['prefix' => 'v1/admin/pushes'], function () {
    Route::post('/', 'PushesController@sendPush');
});