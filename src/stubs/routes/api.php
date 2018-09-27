<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Include all files in app/Routes folder
foreach (File::allFiles(app()->path() . '/Routes/Api') as $route) {
    require_once $route->getPathname();
}