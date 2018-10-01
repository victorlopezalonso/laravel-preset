<?php

namespace App\Http\Requests\Api\App;

use App\Http\Requests\ApiRequest;

/**
 * @SWG\Definition(
 *       definition="ContactMailRequest",
 *       description="Send a mail to the app administrator",
 *       required={"email", "message"},
 *      @SWG\Property(property="email", type="string", description="Valid email"),
 *      @SWG\Property(property="message", type="string", description="Text to send"),
 * )
 */
class ContactMailRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'   => 'email',
            'message' => 'required',
        ];
    }
}
