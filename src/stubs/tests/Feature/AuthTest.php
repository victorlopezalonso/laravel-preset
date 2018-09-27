<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Tests\ApiTestCase;

class AuthTest extends ApiTestCase
{

    /** @test */
    public function get_auth_user_returns_a_user_resource()
    {
        $this->signIn(factory(User::class)->create());

        $this->apiCall('get', 'api/v1/auth')->assertStatus(HTTP_CODE_200_OK);

        $this->assertDataHasAttributes([
            'name',
            'email',
            'photo'
        ]);
    }

    /** @test */
    public function update_returns_the_updated_resource()
    {
        $this->signIn(factory(User::class)->create(['verified' => true]));

        $this->params = [
            'name'     => 'name',
            'password' => 'newPassword'
        ];

        $this->apiCall('put', 'api/v1/auth')->assertStatus(HTTP_CODE_200_OK)->assertSee('name');

        $this->params = [
            'type'     => 1,
            'name'     => 'name',
            'email'    => $this->user->email,
            'password' => 'newPassword',
        ];

        $this->apiCall('post', 'api/v1/session')->assertStatus(HTTP_CODE_200_OK);
    }

    /** @test */
    public function a_user_can_update_the_profile_photo()
    {
        $this->signIn(factory(User::class)->create());

        $this->params = [
            'photo' => UploadedFile::fake()->image('newphoto.jpg')->size(100)
        ];

        $this->apiCall('post', 'api/v1/auth/photo')->assertStatus(HTTP_CODE_200_OK)->assertSee('photo');

        $this->assertNotNull($this->response['data']->photo);
    }

    /** @test */
    public function a_user_can_update_the_password()
    {
        $user = factory(User::class)->create(['password' => 'password', 'verified' => true]);
        $this->signIn($user);

        $this->params = ['password' => 'newPassword'];

        $this->apiCall('put', 'api/v1/auth/password')->assertStatus(HTTP_CODE_200_OK);

        $this->params = [
            'type'     => 1,
            'email'    => $user->email,
            'password' => 'newPassword',
        ];

        $this->apiCall('post', 'api/v1/session')->assertStatus(HTTP_CODE_200_OK);
    }

    /** @test */
    public function a_user_can_be_deleted_from_database()
    {
        $this->signIn(factory(User::class)->create());

        $this->apiCall('delete', 'api/v1/auth')->assertStatus(HTTP_CODE_200_OK);
    }

    /** @test */
    public function a_user_can_update_its_push_token()
    {
        /** @var User $user */
        $user = factory(User::class)->create();

        $this->signIn($user);

        //************************************
        //first token -> pushtokens = 1
        //************************************
        $this->params = ['token' => 'token1'];

        $this->apiCall('post', 'api/v1/auth/pushtoken')->assertStatus(HTTP_CODE_201_OK_CREATED);

        self::assertEquals(1, $user->pushTokens()->count());

        //************************************
        //second token (same token) -> pushtokens = 1
        //************************************
        $this->params = ['token' => 'token1'];

        $this->apiCall('post', 'api/v1/auth/pushtoken')->assertStatus(HTTP_CODE_201_OK_CREATED);

        self::assertEquals(1, $user->pushTokens()->count());

        //************************************
        //third token -> pushtokens = 2 if user has multiple push tokens
        //************************************
        $this->params = ['token' => 'token2'];

        $this->apiCall('post', 'api/v1/auth/pushtoken')->assertStatus(HTTP_CODE_201_OK_CREATED);

        if (USER_HAS_MULTIPLE_PUSH_TOKENS) {
            self::assertEquals(2, $user->pushTokens()->count());
        } else {
            self::assertEquals(1, $user->pushTokens()->count());
        }

    }

}