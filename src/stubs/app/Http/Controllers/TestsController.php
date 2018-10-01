<?php

namespace App\Http\Controllers;

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
