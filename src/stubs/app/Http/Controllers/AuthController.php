<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Api\Users\UserUpdateRequest;
use App\Http\Resources\Api\Users\UserProfileResource;
use App\Http\Requests\Api\Users\UpdatePasswordRequest;
use App\Http\Requests\Api\Users\UserAddOrUpdatePushTokenRequest;

class AuthController extends ApiController
{
    /**
     * Return the user profile.
     *
     * @return \App\Http\Responses\ApiResponse
     */
    public function show()
    {
        $user = new UserProfileResource($this->user());

        return $this->response($user);
    }

    /**
     * Update the auth user profile and return the user.
     *
     * @param UserUpdateRequest $request
     *
     * @return \App\Http\Responses\ApiResponse
     */
    public function update(UserUpdateRequest $request)
    {
        if ($request->get('password') && Hash::check($request->get('password'), $this->user()->getAuthPassword())) {
            return $this->responseWithConflict('UPDATING_WITH_THE_SAME_PASSWORD');
        }

        $this->user()->updateProfile($request);

        return $this->response(new UserProfileResource($this->user()));
    }

    /**
     * Update the auth user photo.
     *
     * @return \App\Http\Responses\ApiResponse
     */
    public function photo()
    {
        $this->user()->savePhoto();

        return $this->response(new UserProfileResource($this->user()));
    }

    /**
     * @param UpdatePasswordRequest $request
     *
     * @return \App\Http\Responses\ApiResponse
     */
    public function updatePassword(UpdatePasswordRequest $request)
    {
        $this->user()->updatePassword($request);

        return $this->withMessage('PASSWORD_MODIFIED');
    }

    /**
     * @param UserAddOrUpdatePushTokenRequest $request
     *
     * @return \App\Http\Responses\ApiResponse
     */
    public function addOrUpdatePushToken(UserAddOrUpdatePushTokenRequest $request)
    {
        $this->user()->addOrUpdatePushToken($request);

        return $this->withStatus(HTTP_CODE_201_OK_CREATED);
    }

    /**
     * Deletes the user.
     *
     * @throws \Exception
     */
    public function destroy()
    {
        $this->user()->delete();

        return $this->response();
    }
}
