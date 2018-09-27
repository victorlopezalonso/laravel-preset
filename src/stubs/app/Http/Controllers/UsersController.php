<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiBadRequestException;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Requests\Api\Users\UserSendResetLinkEmailRequest;
use App\Http\Resources\Api\Users\UserProfileResource;
use App\Http\Requests\Api\Users\UserRegisterRequest;
use App\Http\Resources\Api\Users\UserPublicProfileResource;
use App\Http\Responses\ApiResponse;
use App\Models\Copy;
use App\Models\User;

class UsersController extends ApiController
{

    /**
     * User registration
     *
     * @param UserRegisterRequest $request
     * @return ApiResponse
     * @throws \Throwable
     */
    public function register(UserRegisterRequest $request)
    {
        switch ($request->type) {

            case MAIL_USER:
                $user = User::registerWithEmail($request);
                break;

            case FACEBOOK_USER:
                $user = User::registerWithFacebook($request);
                break;

            case GOOGLE_USER:
                $user = User::registerWithGoogle($request);
                break;

            default:
                throw new ApiBadRequestException('SERVER_GENERIC_ERROR');
        }

        if (USER_MUST_VERIFY_EMAIL) {
            return $this->responseAccepted(new UserProfileResource($user))
                        ->withMessage(Copy::server('USER_REGISTER_CONFIRM'));
        }

        return $this->responseCreated(new UserProfileResource($user))->withMessage(Copy::server('USER_REGISTER_OK'));
    }

    /**
     * Send a reset password link to the user
     *
     * @param UserSendResetLinkEmailRequest $request
     * @return ApiResponse
     */
    public function sendResetLinkEmail(UserSendResetLinkEmailRequest $request)
    {
        (new ForgotPasswordController)->sendResetLinkEmail($request);

        return $this->withMessage('PASSWORD_RESET_EMAIL_SENT')->withStatus(HTTP_CODE_202_OK_ACCEPTED);
    }

    /**
     * Show a list of users
     *
     * @return ApiResponse
     */
    public function getUsers()
    {
        return $this->response(UserPublicProfileResource::collection(User::paginate()));
    }

    /**
     * Show user's public profile
     *
     * @param User $user
     * @return ApiResponse
     */
    public function profile(User $user)
    {
        return $this->response(new UserPublicProfileResource($user));
    }

    /**
     * Mail verification result view
     *
     * @param $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function verifyMail($token)
    {
        $user = User::verifyMail($token);

        $message = $user ? Copy::server('USER_MAIL_VERIFIED', $user->name) : Copy::server('USER_MAIL_NOT_VERIFIED');

        return view('mails.verification-mail-result', compact('message'));
    }

}
