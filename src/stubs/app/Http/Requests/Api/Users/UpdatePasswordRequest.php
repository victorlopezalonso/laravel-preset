<?php

namespace App\Http\Requests\Api\Users;

use App\Http\Requests\ApiRequest;

/**
 * @SWG\Definition(
 *       definition="UpdatePasswordRequest",
 *       description="Update user password",
 *       required={"password"},
 *      @SWG\Property(property="password", type="string", description="User password encrypted with APP_HASH"),
 *   )
 */
class UpdatePasswordRequest extends ApiRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password' => 'required|min:3',
        ];
    }

}
