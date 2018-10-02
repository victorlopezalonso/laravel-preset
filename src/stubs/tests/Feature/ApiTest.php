<?php

namespace Tests\Feature;

use App\Models\Config;
use Carbon\Carbon;
use Tests\ApiTestCase;

class ApiTest extends ApiTestCase
{

    /** @test */
    public function call_to_wrong_method_or_route_returns_404()
    {
        $this->apiCall('post', 'wrong/service')->assertStatus(HTTP_CODE_404_NOT_FOUND);
    }

    /** @test */
    public function call_to_tests_route_with_correct_apikey_returns_200()
    {
        $this->apiCall('post', 'api/v1/tests/phpunit')->assertStatus(HTTP_CODE_200_OK);
    }

    /** @test */
    public function call_to_tests_route_with_wrong_apikey_returns_422()
    {
        $this->setHeader('apiKey', 'wrong apikey');

        $this->apiCall('post', 'api/v1/tests/phpunit')->assertStatus(HTTP_CODE_422_UNPROCESSABLE_ENTITY);
    }

}