<?php

namespace App\Http\Resources\Api\Users;

use Illuminate\Http\Resources\Json\Resource;

/**
 * @SWG\Definition(
 *       definition="UserAccessToken",
 *       description="User Access Token",
 *      @SWG\Property(property="authorization", ref="#/definitions/AccessToken")
 * )
 */
class UserAccessTokenResource extends Resource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'authorization' => $this->when($this->authorization, $this->authorization),
        ];
    }
}
