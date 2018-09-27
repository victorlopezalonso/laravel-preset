<?php

namespace App\Http\Resources\Admin\Users;

use App\Models\User;
use Illuminate\Http\Resources\Json\Resource;

class UserProfileResource extends Resource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var User $this */
        return [
            'id'                   => $this->id,
            'uuid'                 => $this->uuid,
            'name'                 => $this->name,
            'lastname'             => $this->lastname,
            'email'                => $this->email,
            'birthDate'            => $this->birthdate,
            'address'              => $this->address,
            'city'                 => $this->city,
            'postcode'             => $this->postcode,
            'identificationNumber' => $this->identification_number,
            'permissions'          => $this->permissions,
            'isAdmin'              => $this->is_admin,
            'authorization'        => $this->when($this->authorization, $this->authorization),
        ];
    }
}
