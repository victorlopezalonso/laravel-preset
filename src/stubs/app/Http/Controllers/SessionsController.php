<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Exceptions\ApiException;
use App\Http\Requests\Api\Users\UserLoginRequest;
use App\Http\Resources\Api\Users\UserProfileResource;
use App\Http\Resources\Api\Users\UserAccessTokenResource;

class SessionsController extends ApiController
{

    /**
     * Login a user.
     *
     * @param UserLoginRequest $request
     *
     * @throws ApiException
     * @throws \Throwable
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @return \App\Http\Responses\ApiResponse
     */
    public function store(UserLoginRequest $request)
    {
        switch ($request->get('type')) {
            case MAIL_USER:
                $user = User::loginWithEmail($request);

                break;
            case FACEBOOK_USER:
                $user = User::loginWithFacebook($request);

                break;
            case GOOGLE_USER:
                $user = User::loginWithGoogle($request);

                break;
            default:
                throw new ApiException();
        }

        return $user ? $this->response(new UserProfileResource($user)) : $this->responseNotFound('USER_LOGIN_KO');
    }

    /**
     * Update the user access token.
     *
     * @throws \Throwable
     *
     * @return \App\Http\Responses\ApiResponse
     */
    public function update()
    {
        if (! $user = User::byToken()) {
            return $this->responseNotFound();
        }

        $user->refreshToken();

        return $this->response(new UserAccessTokenResource($user));
    }

    /**
     * Logout the auth user and delete the user token.
     */
    public function destroy()
    {
        if (! $user = User::byToken()) {
            return;
        }

        $user->revokeRequestedAccessToken();
    }
}
