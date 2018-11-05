<?php

Route::group(['prefix' => 'v1/users'], function () {

    /** ***********************************************************
     *  Register a new user with verification mail
     *  ***********************************************************
     * @SWG\Post(
     *     tags={"Users"},
     *     path="/api/v1/users",
     *     summary="Register a new user (Accept a 'photo' parameter using multipart/form-data)",
     *     @SWG\Parameter(ref="#/parameters/apiKey"),
     *     @SWG\Parameter(ref="#/parameters/Language"),
     *     @SWG\Parameter(ref="#/parameters/os"),
     *     @SWG\Parameter(ref="#/parameters/appVersion"),
     *     @SWG\Parameter(name="body", in="body", @SWG\Schema(ref="#/definitions/UserRegisterRequest")),
     *     @SWG\Response(response=HTTP_CODE_201_OK_CREATED, description="User created", @SWG\Schema(ref="#/definitions/UserProfileResource")),
     *     @SWG\Response(response=HTTP_CODE_202_OK_ACCEPTED, description="User registered, verification needed"),
     * )
     */
    Route::post('/', 'UsersController@register');

    /** ***********************************************************
     *  Send an email to the user with a link to reset the password
     *  ***********************************************************
     * @SWG\Put(
     *     tags={"Users"},
     *     path="/api/v1/users/password",
     *     summary="Send an email to the user with a link to reset the password",
     *     @SWG\Parameter(ref="#/parameters/apiKey"),
     *     @SWG\Parameter(ref="#/parameters/Language"),
     *     @SWG\Parameter(ref="#/parameters/os"),
     *     @SWG\Parameter(ref="#/parameters/appVersion"),
     *     @SWG\Parameter(name="body", in="body", @SWG\Schema(ref="#/definitions/UserSendResetLinkEmailRequest")),
     *     @SWG\Response(response=HTTP_CODE_202_OK_ACCEPTED, description="Email sent"),
     * )
     */
    Route::put('/password', 'UsersController@sendResetLinkEmail');

    /** ***********************************************************
     *  Show user's public profile
     * ************************************************************
     * @SWG\Get(
     *      tags={"Users"},
     *      path="/api/v1/users/{id}",
     *      summary="Show user's public profile",
     *      @SWG\Parameter(ref="#/parameters/apiKey"),
     *      @SWG\Parameter(ref="#/parameters/Language"),
     *      @SWG\Parameter(ref="#/parameters/os"),
     *      @SWG\Parameter(ref="#/parameters/appVersion"),
     *      @SWG\Parameter(name="id", in="path", type="string"),
     *      @SWG\Response(response=HTTP_CODE_200_OK, description="Users", @SWG\Schema(ref="#/definitions/UserPublicProfileResource")),
     * )
     */
    Route::get('/{user}', 'UsersController@profile');

});
