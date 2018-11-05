<?php

namespace Tests\Feature;

use Carbon\Carbon;
use App\Models\Config;
use Tests\ApiTestCase;

class SplashTest extends ApiTestCase
{

    /** @test */
    public function splash_in_maintenance_returns_503()
    {
        Config::first()->update(['app_in_maintenance' => true]);

        $this->apiCall('get', 'api/v1/app/splash')->assertStatus(HTTP_CODE_503_SERVICE_UNAVAILABLE);
    }

    /** @test */
    public function splash_without_params_returns_422()
    {
        $this->emptyHeaders();

        $this->apiCall('get', 'api/v1/app/splash')->assertStatus(HTTP_CODE_422_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function splash_with_outdated_app_version_returns_426_with_message()
    {
        $this->setHeader(APP_VERSION_HEADER, '0.0.0');

        $this->apiCall('get', 'api/v1/app/splash')->assertStatus(HTTP_CODE_426_UPGRADE_REQUIRED);

        $this->assertMessage(APP_VERSION_OUTDATED);
    }

    /** @test */
    public function splash_with_outdated_copies_returns_200_with_copies()
    {
        $this->setHeader(APP_VERSION_HEADER, Config::first()->ios_version);

        $this->apiCall('get', 'api/v1/app/splash')->assertStatus(HTTP_CODE_200_OK);

        $this->assertNotNull($this->data->copies);
    }

    /** @test */
    public function splash_with_up_to_date_copies_returns_200_without_copies()
    {
        $this->setHeader(APP_VERSION_HEADER, Config::first()->ios_version);

        $this->setParam('copiesUpdatedAt', Carbon::now()->toDateTimeString());

        $this->apiCall('get', 'api/v1/app/splash')->assertStatus(HTTP_CODE_200_OK);

        $this->assertNull($this->data->copies);
    }

    /** @test */
    public function splash__returns_correct_resource()
    {
        $this->setHeader(APP_VERSION_HEADER, Config::first()->ios_version);

        $this->apiCall('get', 'api/v1/app/splash')->assertStatus(HTTP_CODE_200_OK)
        ->assertSee('language')
        ->assertSee('copiesUpdatedAt')
        ->assertSee('contactMail')
        ->assertSee('faqUrl')
        ->assertSee('termsUrl')
        ->assertSee('privacyUrl')
        ->assertSee('deeplinkUrl')
        ->assertSee('linkedinUrl')
        ->assertSee('twitterUrl')
        ->assertSee('facebookUrl')
        ->assertSee('instagramUrl')
        ->assertSee('youtubeUrl')
        ->assertSee('webUrl')
        ->assertSee('languages')
        ->assertSee('copies');
    }

}