<?php

namespace App\Http\Resources\Api\Users;

use Illuminate\Http\Resources\Json\Resource;

/**
 * @SWG\Definition(
 *       definition="UserPublicProfileResource",
 *       description="User public profile",
 *      @SWG\Property(property="id", type="integer", description="User ID"),
 *      @SWG\Property(property="name", type="string", description="User name"),
 *      @SWG\Property(property="lastname", type="string", description="User lastname"),
 *      @SWG\Property(property="photo", type="string", description="User profile's photo public url"),
 * )
 */
class UserPublicProfileResource extends Resource
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
        return [
            'id'       => $this->id,
            'name'     => $this->name,
            'lastname' => $this->lastname,
            'photo'    => $this->photo,
        ];
    }
}
