<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Config;
use App\Models\Folder;
use Tests\ApiTestCase;

class UsersTest extends ApiTestCase
{

    /** @test */
    public function registration_without_params_returns_422()
    {
        $this->apiCall('post', 'api/v1/users')->assertStatus(HTTP_CODE_422_UNPROCESSABLE_ENTITY)->assertSee('type');
    }

    /** @test */
    public function registration_validations_returns_422()
    {
        $this->params['type'] = 1;

        $this->apiCall('post', 'api/v1/users')
             ->assertStatus(HTTP_CODE_422_UNPROCESSABLE_ENTITY)
             ->assertSee('email')
             ->assertSee('password');

        $this->params['type'] = 2;

        $this->apiCall('post', 'api/v1/users')
             ->assertStatus(HTTP_CODE_422_UNPROCESSABLE_ENTITY)
             ->assertSee('accessToken');

        $this->params['type'] = 3;

        $this->apiCall('post', 'api/v1/users')
             ->assertStatus(HTTP_CODE_422_UNPROCESSABLE_ENTITY)
             ->assertSee('accessToken');
    }

    /** @test
     * @throws \Exception
     */
    public function registration_with_mail()
    {
        $this->params = [
            'type'     => 1,
            'name'     => 'username',
            'email'    => 'nonexisting@email.com',
            'password' => 'Passwd01',
        ];

        $this->apiCall('post', 'api/v1/users');

        if (USER_MUST_VERIFY_EMAIL) {
            $this->testResponse->assertStatus(HTTP_CODE_202_OK_ACCEPTED);

            $this->assertMessage('USER_REGISTER_CONFIRM');

            $this->assertSeeMailTo('nonexisting@email.com');
        } else {
            $this->testResponse->assertStatus(HTTP_CODE_201_OK_CREATED)->assertSee('authorization');

            $this->assertMessage('USER_REGISTER_OK');
        }

    }

    /** @test
     * @throws \Exception
     */
    public function registration_with_facebook()
    {
        $this->params = [
            'type'        => 2,
            'accessToken' => '123456789',
        ];

        $this->apiCall('post', 'api/v1/users');

        if (USER_MUST_VERIFY_EMAIL) {
            $this->testResponse->assertStatus(HTTP_CODE_202_OK_ACCEPTED);

            $this->assertMessage('USER_REGISTER_CONFIRM');

            $this->assertSeeMailTo('fakeemail@example.org');
        } else {
            $this->testResponse->assertStatus(HTTP_CODE_201_OK_CREATED)->assertSee('authorization');

            $this->assertMessage('USER_REGISTER_OK');
        }
    }

    /** @test
     * @throws \Exception
     */
    public function registration_with_google()
    {
        $this->params = [
            'type'        => 3,
            'accessToken' => '000000000000000000',
        ];

        $this->apiCall('post', 'api/v1/users');

        if (USER_MUST_VERIFY_EMAIL) {
            $this->testResponse->assertStatus(HTTP_CODE_202_OK_ACCEPTED);

            $this->assertMessage('USER_REGISTER_CONFIRM');

            $this->assertSeeMailTo('fakeemail@example.org');
        } else {
            $this->testResponse->assertStatus(HTTP_CODE_201_OK_CREATED)->assertSee('authorization');

            $this->assertMessage('USER_REGISTER_OK');
        }
    }

    /** @test */
    public function a_user_has_a_public_profile()
    {
        $user = factory(User::class)->create();

        $this->apiCall('get', 'api/v1/users/' . $user->id)
             ->assertStatus(HTTP_CODE_200_OK)
             ->assertSee('name')
             ->assertSee('lastname')
             ->assertSee('photo');
    }

    /**
     * @test
     * @throws \Exception
     */
    public function user_receives_a_mail_to_reset_the_password()
    {
        $user = factory(User::class)->create();

        $this->params = ['email' => $user->email];

        $this->apiCall('put', 'api/v1/users/password')->assertStatus(HTTP_CODE_202_OK_ACCEPTED);

        $this->assertMessage('PASSWORD_RESET_EMAIL_SENT');

        $this->assertEmailWasSent();

        $this->assertSeeMailTo($user->email);
    }

    /**
     * @test
     * @throws \Exception
     */
    public function user_can_contact_with_the_admin()
    {
        Config::first()->update(['contact_mail' => 'mail@example.org']);
        $user = factory(User::class)->create();

        $this->params = [
            'email'   => $user->email,
            'message' => 'Hi',
        ];

        $this->apiCall('post', 'api/v1/app/contact')->assertStatus(HTTP_CODE_200_OK);

        $this->assertMessage('CONTACT_EMAIL_SENT');

        $this->assertEmailWasSent();

        $this->assertSeeMailTo(Config::first()->contact_mail);
    }

}