<?php

namespace App\Http\Requests\Api\Users;

use App\Http\Requests\ApiRequest;

/**
 * @SWG\Definition(
 *       definition="UserAddOrUpdatePushTokenRequest",
 *       description="Add or update the user's push token (player id)",
 *       required={"token"},
 *      @SWG\Property(property="token", type="string", description="User's push token (player id)"),
 *   )
 */
class UserAddOrUpdatePushTokenRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'token' => 'required',
        ];
    }
}
