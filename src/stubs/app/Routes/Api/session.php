<?php

Route::group(['prefix' => 'v1/session'], function () {

    /** ***********************************************************
     *  User login
     *  ***********************************************************
     * @SWG\Post(
     *      tags={"Session"},
     *      path="/api/v1/session",
     *      summary="User login",
     *      @SWG\Parameter(ref="#/parameters/apiKey"),
     *      @SWG\Parameter(ref="#/parameters/Language"),
     *      @SWG\Parameter(ref="#/parameters/os"),
     *      @SWG\Parameter(ref="#/parameters/appVersion"),
     *      @SWG\Parameter(name="body", in="body", @SWG\Schema(ref="#/definitions/UserLoginRequest")),
     *      @SWG\Response(response=HTTP_CODE_200_OK, description="User profile", @SWG\Schema(ref="#/definitions/UserProfileResource")),
     * )
     */
    Route::post('/', 'SessionsController@store');

    /** ***********************************************************
     *  Refresh session
     *  ***********************************************************
     * @SWG\Put(
     *      tags={"Session"},
     *      path="/api/v1/session",
     *      summary="Refresh session",
     *      @SWG\Parameter(ref="#/parameters/apiKey"),
     *      @SWG\Parameter(ref="#/parameters/Language"),
     *      @SWG\Parameter(ref="#/parameters/os"),
     *      @SWG\Parameter(ref="#/parameters/appVersion"),
     *      @SWG\Parameter(ref="#/parameters/Authorization"),
     *      @SWG\Parameter(ref="#/parameters/refreshToken"),
     *      @SWG\Response(response=HTTP_CODE_200_OK, description="New Access Token for the user", @SWG\Schema(ref="#/definitions/AccessToken")),
     *      @SWG\Response(response=HTTP_CODE_401_UNAUTHORIZED, description="Refresh token has expired, user must login to get a new Access Token")
     * )
     */
    Route::put('/', 'SessionsController@update');

    /** ***********************************************************
     *  User logout
     *  ***********************************************************
     * @SWG\Delete(
     *      tags={"Session"},
     *      path="/api/v1/session",
     *      summary="User logout",
     *      @SWG\Parameter(ref="#/parameters/apiKey"),
     *      @SWG\Parameter(ref="#/parameters/Language"),
     *      @SWG\Parameter(ref="#/parameters/os"),
     *      @SWG\Parameter(ref="#/parameters/appVersion"),
     *      @SWG\Parameter(ref="#/parameters/Authorization"),
     *      @SWG\Response(response=HTTP_CODE_200_OK, description="User logged out"),
     * )
     */
    Route::delete('/', 'SessionsController@destroy');

});
