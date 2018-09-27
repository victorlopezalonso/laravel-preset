<?php

namespace App\Http\Requests\Api\Config;

use App\Http\Requests\ApiRequest;

/**
 * @SWG\Parameter(name="copiesUpdatedAt", in="query", type="string", description="timestamp with the last modification of the copies")
 */
class SplashRequest extends ApiRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'copiesUpdatedAt' => 'nullable|date',
        ];
    }
}
