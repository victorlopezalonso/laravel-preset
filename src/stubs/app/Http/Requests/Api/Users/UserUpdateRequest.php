<?php

namespace App\Http\Requests\Api\Users;

use App\Http\Requests\ApiRequest;

/**
 * @SWG\Definition(
 *       definition="UserUpdateRequest",
 *       description="User update request",
 *       required={"name"},
 *      @SWG\Property(property="name", type="string", description="User name"),
 *      @SWG\Property(property="password", type="string", description="User new password (Optional)"),
 *      @SWG\Property(property="email", type="string", description="User email"),
 *   )
 */
class UserUpdateRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'     => 'required',
            'password' => 'nullable',
            'email'    => 'nullable|email',
        ];
    }
}
