<?php

namespace App\Http\Requests\Api\Users;

use App\Http\Requests\ApiRequest;

/**
 * @SWG\Definition(
 *       definition="UserLoginRequest",
 *       description="User login request",
 *       required={"type"},
 *      @SWG\Property(property="type", type="integer", description="1. Email Login | 2. Facebook Login | 3. Google Login"),
 *      @SWG\Property(property="email", type="string", description="User email (required for type 1)"),
 *      @SWG\Property(property="password", type="string", description="User password encrypted with APP_HASH (required for type 1)"),
 *      @SWG\Property(property="facebookId", type="string", description="Facebook unique identifier (required for type 2)"),
 *      @SWG\Property(property="googleId", type="string", description="Google unique identifier (required for type 3)"),
 *      @SWG\Property(property="name", type="string", description="User name (only for social media types)"),
 *      @SWG\Property(property="photo", type="string", description="User's profile photo URL (only for social media types)"),
 *   )
 */
class UserLoginRequest extends ApiRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type'        => 'required|integer|min:1|max:3',
            'email'       => 'required_if:type,1|email',
            'password'    => 'required_if:type,1|min:3',
            'facebookId'  => 'required_if:type,2',
            'googleId'    => 'required_if:type,3',
            'name'        => 'nullable',
            'photo'       => 'nullable',
        ];
    }

}
