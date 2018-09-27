<?php

namespace App\Http\Requests\Api\Users;

use App\Http\Requests\ApiRequest;

/**
 * @SWG\Definition(
 *       definition="UserRegisterRequest",
 *       description="User login request",
 *       required={"type", "name"},
 *      @SWG\Property(property="type", type="integer", description="1. Email Registration | 2. Facebook Registration | 3. Google Registration"),
 *      @SWG\Property(property="name", type="string", description="User name"),
 *      @SWG\Property(property="email", type="string", description="User email (required for type 1)"),
 *      @SWG\Property(property="password", type="string", description="User password encrypted with APP_HASH (required for type 1)"),
 *      @SWG\Property(property="facebookId", type="string", description="Facebook unique identifier (required for type 2)"),
 *      @SWG\Property(property="googleId", type="string", description="Google unique identifier (required for type 3)"),
 *      @SWG\Property(property="advertising", type="boolean", description="User accepts receiving offers"),
 *   )
 */
class UserRegisterRequest extends ApiRequest
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
            'name'        => 'nullable',
            'email'       => 'required_if:type,1|email|unique:users,email',
            'password'    => 'required_if:type,1|min:3',
            'facebookId'  => 'required_if:type,2',
            'googleId'    => 'required_if:type,3',
        ];
    }

}
