<?php

Route::group(['prefix' => 'v1/app'], function () {

    /** ***********************************************************
     *  Return the configuration to load in the splash
     *  ***********************************************************
     * @SWG\Get(
     *      tags={"App"},
     *      path="/api/v1/app/splash",
     *      summary="Return the configuration to load in the splash",
     *      @SWG\Parameter(ref="#/parameters/apiKey"),
     *      @SWG\Parameter(ref="#/parameters/Language"),
     *      @SWG\Parameter(ref="#/parameters/os"),
     *      @SWG\Parameter(ref="#/parameters/appVersion"),
     *      @SWG\Parameter(ref="#/parameters/copiesUpdatedAt"),
     *      @SWG\Response(response=HTTP_CODE_200_OK, description="Splash resource", @SWG\Schema(ref="#/definitions/SplashResource")),
     *      @SWG\Response(response=HTTP_CODE_426_UPGRADE_REQUIRED, description="App outdated, redirect to the market"),
     *      @SWG\Response(response=HTTP_CODE_503_SERVICE_UNAVAILABLE, description="App is in maintenance, show the message block the app"),
     * )
     */
    Route::get('/splash', 'AppController@splash');

    /** ***********************************************************
     *  Send a mail to the app administrator
     *  ***********************************************************
     * @SWG\Post(
     *      tags={"App"},
     *      path="/api/v1/app/contact",
     *      summary="Send a mail to the app administrator",
     *      @SWG\Parameter(ref="#/parameters/apiKey"),
     *      @SWG\Parameter(ref="#/parameters/Language"),
     *      @SWG\Parameter(ref="#/parameters/os"),
     *      @SWG\Parameter(ref="#/parameters/appVersion"),
     *      @SWG\Parameter(name="body", in="body", @SWG\Schema(ref="#/definitions/ContactMailRequest")),
     *      @SWG\Response(response=HTTP_CODE_200_OK, description="Mail sent"),
     * )
     */
    Route::post('/contact', 'AppController@contact');

});