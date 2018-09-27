<?php

Route::group(['prefix' => 'users'], function () {
    Route::get('/verifymail/{token}', 'UsersController@verifyMail')->name('mail.verify');
    Route::get('/passwordreset/ok', 'Auth\ResetPasswordController@passwordResetOk')->name('password.reset.ok');
});