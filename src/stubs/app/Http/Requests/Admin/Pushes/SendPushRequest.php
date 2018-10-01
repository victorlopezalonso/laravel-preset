<?php

namespace App\Http\Requests\Admin\Pushes;

use App\Models\Config;
use App\Http\Requests\ApiRequest;

class SendPushRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'image' => 'nullable|file',
            'url'   => 'nullable|url',
        ];

        foreach (['title', 'header', 'content'] as $param) {
            foreach (Config::languages() as $language) {
                $rules[$param.'.'.$language] = 'nullable';
            }
        }

        return $rules;
    }
}
