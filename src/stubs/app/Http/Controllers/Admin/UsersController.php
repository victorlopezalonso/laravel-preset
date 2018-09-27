<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\ApiUnauthorizedException;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Admin\Users\CreateUserRequest;
use App\Http\Requests\Admin\Users\UpdateUserRequest;
use App\Http\Resources\Admin\Users\UserProfileResource;
use App\Models\User;

class UsersController extends ApiController
{

    /**
     * @return UserProfileResource
     */
    public function getAuthUser()
    {
        return new UserProfileResource(auth()->user());
    }

    public function getUsers()
    {
        return $this->response(UserProfileResource::collection(User::paginate()));
    }

    public function updateUser(User $user, UpdateUserRequest $request)
    {
        $user->update($request->params());
    }

    public function createUser(CreateUserRequest $request)
    {
        $password = request('password');

        $request->set('password', encryptWithAppSecret($password));
        $request->set('isAdmin', true);

        /** @var User $user */
        $user = User::create($request->params());

        $user->sendEmailWithAdminCredentials($password);
    }

    /**
     * @param User $user
     * @throws \Exception
     * @throws \Throwable
     */
    public function deleteUser(User $user)
    {
        throw_if($user->id === auth()->user()->id || $user->hasRootPermissions(), new ApiUnauthorizedException());
        $user->delete();
    }
}
