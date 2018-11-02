<?php

Route::group(['prefix' => 'v1/auth'], function () {

    /** ***********************************************************
     *  Get the auth user profile
     *  ***********************************************************
     * @SWG\Get(
     *      tags={"Auth"},
     *      path="/api/v1/auth",
     *      summary="Get the auth user profile",
     *      @SWG\Parameter(ref="#/parameters/apiKey"),
     *      @SWG\Parameter(ref="#/parameters/Language"),
     *      @SWG\Parameter(ref="#/parameters/os"),
     *      @SWG\Parameter(ref="#/parameters/appVersion"),
     *      @SWG\Parameter(ref="#/parameters/Authorization"),
     *      @SWG\Response(response=HTTP_CODE_200_OK, description="User profile", @SWG\Schema(ref="#/definitions/UserProfileResource")),
     * )
     */
    Route::get('/', 'AuthController@show')->middleware('auth:api');

    /** ***********************************************************
     *  Update auth user
     *  ***********************************************************
     * @SWG\Put(
     *      tags={"Auth"},
     *      path="/api/v1/auth",
     *      summary="Update auth user",
     *      @SWG\Parameter(ref="#/parameters/apiKey"),
     *      @SWG\Parameter(ref="#/parameters/Language"),
     *      @SWG\Parameter(ref="#/parameters/os"),
     *      @SWG\Parameter(ref="#/parameters/appVersion"),
     *      @SWG\Parameter(ref="#/parameters/Authorization"),
     *      @SWG\Parameter(name="body", in="body", @SWG\Schema(ref="#/definitions/UserUpdateRequest")),
     *      @SWG\Response(response=HTTP_CODE_200_OK, description="User profile", @SWG\Schema(ref="#/definitions/UserProfileResource")),
     * )
     */
    Route::put('/', 'AuthController@update')->middleware('auth:api');

    /** ***********************************************************
     *  Update the auth user photo
     *  ***********************************************************
     * @SWG\Post(
     *      tags={"Auth"},
     *      path="/api/v1/auth/photo",
     *      summary="Update the auth user photo (Multipart or Binary)",
     *      consumes={"multipart/form-data"},
     *      @SWG\Parameter(ref="#/parameters/apiKey"),
     *      @SWG\Parameter(ref="#/parameters/Language"),
     *      @SWG\Parameter(ref="#/parameters/os"),
     *      @SWG\Parameter(ref="#/parameters/appVersion"),
     *      @SWG\Parameter(ref="#/parameters/Authorization"),
     *      @SWG\Parameter(name="photo", in="formData", type="file", description="User photo"),
     *      @SWG\Response(response=HTTP_CODE_200_OK, description="User profile", @SWG\Schema(ref="#/definitions/UserProfileResource")),
     * )
     */
    Route::post('/photo', 'AuthController@photo')->middleware('auth:api');

    /** ***********************************************************
     *  Update password
     *  ***********************************************************
     * @SWG\Put(
     *      tags={"Auth"},
     *      path="/api/v1/auth/password",
     *      summary="Update password",
     *      @SWG\Parameter(ref="#/parameters/apiKey"),
     *      @SWG\Parameter(ref="#/parameters/Language"),
     *      @SWG\Parameter(ref="#/parameters/os"),
     *      @SWG\Parameter(ref="#/parameters/appVersion"),
     *      @SWG\Parameter(ref="#/parameters/Authorization"),
     *      @SWG\Parameter(name="body", in="body", @SWG\Schema(ref="#/definitions/UpdatePasswordRequest")),
     *      @SWG\Response(response=HTTP_CODE_200_OK, description="Password updated"),
     * )
     */
    Route::put('/password', 'AuthController@updatePassword')->middleware('auth:api');

    /** ***********************************************************
     *  Add or update the user's push token (player id)
     *  ***********************************************************
     * @SWG\Post(
     *      tags={"Auth"},
     *      path="/api/v1/auth/pushtoken",
     *      summary="Add or update the user's push token (player id)",
     *      @SWG\Parameter(ref="#/parameters/apiKey"),
     *      @SWG\Parameter(ref="#/parameters/Language"),
     *      @SWG\Parameter(ref="#/parameters/os"),
     *      @SWG\Parameter(ref="#/parameters/appVersion"),
     *      @SWG\Parameter(ref="#/parameters/Authorization"),
     *      @SWG\Parameter(name="body", in="body", @SWG\Schema(ref="#/definitions/UserAddOrUpdatePushTokenRequest")),
     *      @SWG\Response(response=HTTP_CODE_201_OK_CREATED, description="User's token (player id) added or updated"),
     * )
     */
    Route::post('/pushtoken', 'AuthController@addOrUpdatePushToken')->middleware('auth:api');

    /** ***********************************************************
     *  Delete User
     *  ***********************************************************
     * @SWG\Delete(
     *      tags={"Auth"},
     *      path="/api/v1/auth",
     *      summary="Delete User",
     *      @SWG\Parameter(ref="#/parameters/apiKey"),
     *      @SWG\Parameter(ref="#/parameters/Language"),
     *      @SWG\Parameter(ref="#/parameters/os"),
     *      @SWG\Parameter(ref="#/parameters/appVersion"),
     *      @SWG\Parameter(ref="#/parameters/Authorization"),
     *      @SWG\Response(response=HTTP_CODE_200_OK, description="User deleted"),
     * )
     */
    Route::delete('/', 'AuthController@destroy')->middleware('auth:api');

});
