<?php

namespace App\Http\Requests\Admin\Config;

use App\Http\Requests\ApiRequest;

class ConfigUpdateRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'appInMaintenance' => 'required|boolean',
            'androidVersion'   => 'required',
            'iosVersion'       => 'required',
            'languages'        => 'required',
            'contactMail'      => 'nullable',
            'faqUrl'           => 'nullable',
            'termsUrl'         => 'nullable',
            'privacyUrl'       => 'nullable',
            'deepLinkUrl'      => 'nullable',
        ];
    }
}
