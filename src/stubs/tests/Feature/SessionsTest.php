<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\ApiTestCase;

class SessionsTest extends ApiTestCase
{

    /** @test */
    public function login_without_params_returns_422_with_validations()
    {
        $this->apiCall('post', 'api/v1/session')->assertStatus(HTTP_CODE_422_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function login_only_with_type1_returns_422_with_validations()
    {
        $this->params = ['type' => 1];

        $this->apiCall('post', 'api/v1/session')
            ->assertStatus(HTTP_CODE_422_UNPROCESSABLE_ENTITY)
            ->assertSee('validations')
            ->assertSee('email')
            ->assertSee('password');
    }

    /** @test */
    public function login_only_with_type2_returns_422_with_validations()
    {
        $this->params = ['type' => 2];

        $this->apiCall('post', 'api/v1/session')
            ->assertStatus(HTTP_CODE_422_UNPROCESSABLE_ENTITY)
            ->assertSee('validations')
            ->assertSee('facebookId');
    }

    /** @test */
    public function login_only_with_type3_returns_422_with_validations()
    {
        $this->params = ['type' => 3];

        $this->apiCall('post', 'api/v1/session')
            ->assertStatus(HTTP_CODE_422_UNPROCESSABLE_ENTITY)
            ->assertSee('validations')
            ->assertSee('googleId');
    }

    /** @test */
    public function login_with_wrong_credentials_returns_404()
    {
        $this->params = [
            'type'     => 1,
            'email'    => 'noexistingemail@nodomain.com',
            'password' => 'nonexistentPassword',
        ];

        $this->apiCall('post', 'api/v1/session')->assertStatus(HTTP_CODE_404_NOT_FOUND);
    }

    /** @test */
    public function login_with_not_verified_credentials_returns_conflict()
    {
        $user = factory(User::class)->create(['password' => 'Passwd01']);

        $this->params = [
            'type'     => 1,
            'email'    => $user->email,
            'password' => 'Passwd01',
        ];

        $this->apiCall('post', 'api/v1/session')->assertStatus(HTTP_CODE_409_CONFLICT);
    }

    /** @test */
    public function login_with_verified_credentials_returns_user()
    {
        $user = factory(User::class)->create([
            'password' => 'Passwd01',
            'verified' => true
        ]);

        $this->params = [
            'type'     => 1,
            'email'    => $user->email,
            'password' => 'Passwd01',
        ];

        $this->apiCall('post', 'api/v1/session')->assertStatus(HTTP_CODE_200_OK)->assertSee('authorization');
    }

    /** @test */
    public function login_with_facebook_returns_user()
    {
        $this->params = [
            'type'       => 2,
            'email'      => 'invented@email.com',
            'facebookId' => '000000000000000000',
        ];

        $this->apiCall('post', 'api/v1/session')->assertStatus(HTTP_CODE_200_OK)->assertSee('authorization');
    }

    /** @test */
    public function login_with_facebook_matches_the_user_if_exists()
    {
        $user = factory(User::class)->create([
            'name'        => 'emailUser',
            'email'       => 'email@user.com',
            'password'    => 'Passwd01',
            'facebook_id' => '000000000000000000',
        ]);

        $this->params = [
            'type'       => 2,
            'email'      => $user->email,
            'facebookId' => $user->facebook_id,
        ];

        $this->apiCall('post', 'api/v1/session')->assertStatus(HTTP_CODE_200_OK)->assertSee('authorization');

        $this->assertEquals($user->name, $this->data->name);
    }

    /** @test */
    public function login_with_google_matches_the_user_if_exists()
    {
        $user = factory(User::class)->create([
            'name'     => 'emailUser',
            'email'    => 'email@user.com',
            'password' => 'Passwd01'
        ]);

        $this->params = [
            'type'     => 3,
            'email'    => 'email@user.com',
            'googleId' => '000000000000000000',
        ];

        $this->apiCall('post', 'api/v1/session')->assertStatus(HTTP_CODE_200_OK)->assertSee('authorization');

        $this->assertEquals($user->name, $this->data->name);
    }

    /** @test */
    public function login_with_google_returns_user()
    {
        $this->params = [
            'type'     => 3,
            'email'    => 'invented@email.com',
            'googleId' => '000000000000000000',
        ];

        $this->apiCall('post', 'api/v1/session')->assertStatus(HTTP_CODE_200_OK)->assertSee('authorization');
    }

    /** @test */
    public function an_auth_user_can_update_the_token()
    {
        if (!TOKEN_EXPIRES) {
            $this->assertTrue(true);

            return;
        }

        $this->login_with_verified_credentials_returns_user();

        $auth = $this->response['data']->authorization;

        $this->setHeader('Authorization', 'Bearer ' . $auth->accessToken);
        $this->setHeader('refreshToken', $auth->refreshToken);

        $this->apiCall('put', 'api/v1/session')->assertStatus(HTTP_CODE_200_OK)->assertSee('authorization');
    }

    /** @test */
    public function logout_deletes_the_user_token()
    {
        $this->login_with_verified_credentials_returns_user();

        $this->setHeader('Authorization', 'Bearer ' . $this->response['data']->authorization->accessToken);

        $this->apiCall('delete', 'api/v1/session')->assertStatus(HTTP_CODE_200_OK);
    }

}