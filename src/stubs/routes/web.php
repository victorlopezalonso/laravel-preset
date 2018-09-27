<?php

// Main Page
Route::get('/', function () {
    return view('welcome');
});

// Admin Page
Route::get('/home', 'HomeController@index')->name('home');

// Login-Register web routes
Auth::routes();

// Web Routes
App\Classes\Console::addWebRoutes();

// Admin Routes
App\Classes\Console::addAdminRoutes();
