<?php

namespace App\Http\Requests\Api\Users;

use App\Http\Requests\ApiRequest;

/**
 * @SWG\Definition(
 *       definition="UserSendResetLinkEmailRequest",
 *       description="User forgot password request",
 *       required={"email"},
 *       @SWG\Property(property="email", type="string", description="User email"),
 *   )
 */
class UserSendResetLinkEmailRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|exists:users',
        ];
    }
}
