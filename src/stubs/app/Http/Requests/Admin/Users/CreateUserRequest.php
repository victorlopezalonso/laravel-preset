<?php

namespace App\Http\Requests\Admin\Users;

use App\Http\Requests\ApiRequest;

class CreateUserRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'        => 'required',
            'email'       => 'email',
            'password'    => 'nullable',
            'permissions' => 'nullable',
            'isAdmin'     => 'nullable',
        ];
    }
}
