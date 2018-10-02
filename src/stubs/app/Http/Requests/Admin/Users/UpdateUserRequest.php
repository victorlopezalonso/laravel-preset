<?php

namespace App\Http\Requests\Admin\Users;

use App\Http\Requests\ApiRequest;

class UpdateUserRequest extends ApiRequest
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
            'lastname'    => 'nullable',
            'email'       => 'required|email',
            'permissions' => 'required',
        ];
    }
}
