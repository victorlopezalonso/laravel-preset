<?php

Route::group(['prefix' => 'v1/tests'], function () {

    /** ***********************************************************
     *  test
     *  ***********************************************************
     * @SWG\Post(
     *      tags={"Tests"},
     *      path="/api/v1/tests",
     *      summary="Test",
     *      @SWG\Parameter(ref="#/parameters/apiKey"),
     *      @SWG\Parameter(ref="#/parameters/Language"),
     *      @SWG\Parameter(ref="#/parameters/os"),
     *      @SWG\Response(response=HTTP_CODE_200_OK, description="Test response")),
     * )
     */
    Route::any('/', 'TestsController@test');

    /**
     * PHPUNIT TEST ROUTE
     */
    Route::any('/phpunit', function () {
        return;
    });

});