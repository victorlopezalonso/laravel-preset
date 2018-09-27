<?php

namespace App\Http\Controllers;


use App\Classes\OneSignal;
use App\Models\File;

class TestsController extends ApiController
{

    /**
     * @return \App\Http\Responses\ApiResponse
     */
    public function test()
    {
        return $this->response(request()->all());
    }

}
