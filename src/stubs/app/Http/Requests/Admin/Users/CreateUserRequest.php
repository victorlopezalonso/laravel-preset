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
            'name'                  => 'required',
            'email'                 => 'email',
            'password'              => 'nullable',
            'permissions'           => 'nullable',
            'isAdmin'               => 'nullable',
            'lastname'              => 'nullable',
            'birthDate'             => 'nullable',
            'address'               => 'nullable',
            'city'                  => 'nullable',
            'country'               => 'nullable',
            'postcode'              => 'nullable',
            'identificationNumber'  => 'nullable',
            'gender'                => 'nullable',
            'photo'                 => 'nullable',
            'facebookUrl'           => 'nullable',
            'twitterUrl'            => 'nullable',
            'instagramUrl'          => 'nullable',
        ];
    }
}
