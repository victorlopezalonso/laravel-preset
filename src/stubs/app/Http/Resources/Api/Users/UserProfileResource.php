<?php

namespace App\Http\Resources\Api\Users;

use Illuminate\Http\Resources\Json\Resource;

/**
 * @SWG\Definition(
 *       definition="UserProfileResource",
 *       description="Auth user profile",
 *      @SWG\Property(property="id", type="integer", description="User ID"),
 *      @SWG\Property(property="name", type="string", description="User name"),
 *      @SWG\Property(property="email", type="string", description="User email"),
 *      @SWG\Property(property="photo", type="string", description="User profile's photo public url"),
 *      @SWG\Property(property="authorization", ref="#/definitions/AccessToken")
 * )
 */
class UserProfileResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        // @var User $this
        return [
            'id'                    => $this->id,
            'name'                  => $this->name,
            'email'                 => $this->email,
            'photo'                 => $this->photo,
            'authorization'         => $this->when($this->authorization, $this->authorization),
        ];
    }
}
