<?php

namespace App\Http\Requests;

use App\Models\Copy;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ApiRequest.
 */
class ApiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Custom messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'accepted'             => Copy::server('VALIDATION_ACCEPTED'),
            'active_url'           => Copy::server('VALIDATION_ACTIVE_URL'),
            'after'                => Copy::server('VALIDATION_AFTER'),
            'after_or_equal'       => Copy::server('VALIDATION_AFTER_OR_EQUAL'),
            'alpha'                => Copy::server('VALIDATION_ALPHA'),
            'alpha_dash'           => Copy::server('VALIDATION_ALPHA_DASH'),
            'alpha_num'            => Copy::server('VALIDATION_ALPHA_NUM'),
            'array'                => Copy::server('VALIDATION_ARRAY'),
            'before'               => Copy::server('VALIDATION_BEFORE'),
            'before_or_equal'      => Copy::server('VALIDATION_BEFORE_OR_EQUAL'),
            'between'              => [
                'numeric' => Copy::server('VALIDATION_BETWEEN_NUMERIC'),
                'file'    => Copy::server('VALIDATION_BETWEEN_FILE'),
                'string'  => Copy::server('VALIDATION_BETWEEN_STRING'),
                'array'   => Copy::server('VALIDATION_BETWEEN_ARRAY'),
            ],
            'boolean'              => Copy::server('VALIDATION_BOOLEAN'),
            'confirmed'            => Copy::server('VALIDATION_CONFIRMED'),
            'date'                 => Copy::server('VALIDATION_DATE'),
            'date_format'          => Copy::server('VALIDATION_DATE_FORMAT'),
            'different'            => Copy::server('VALIDATION_DIFFERENT'),
            'digits'               => Copy::server('VALIDATION_DIGITS'),
            'digits_between'       => Copy::server('VALIDATION_DIGITS_BETWEEN'),
            'dimensions'           => Copy::server('VALIDATION_DIMENSIONS'),
            'distinct'             => Copy::server('VALIDATION_DISTINCT'),
            'email'                => Copy::server('VALIDATION_EMAIL'),
            'exists'               => Copy::server('VALIDATION_EXISTS'),
            'file'                 => Copy::server('VALIDATION_FILE'),
            'filled'               => Copy::server('VALIDATION_FILLED'),
            'image'                => Copy::server('VALIDATION_IMAGE'),
            'in'                   => Copy::server('VALIDATION_IN'),
            'in_array'             => Copy::server('VALIDATION_IN_ARRAY'),
            'integer'              => Copy::server('VALIDATION_INTEGER'),
            'ip'                   => Copy::server('VALIDATION_IP'),
            'ipv4'                 => Copy::server('VALIDATION_IPV4'),
            'ipv6'                 => Copy::server('VALIDATION_IPV6'),
            'json'                 => Copy::server('VALIDATION_JSON'),
            'max'                  => [
                'numeric' => Copy::server('VALIDATION_MAX_numeric'),
                'file'    => Copy::server('VALIDATION_MAX_file'),
                'string'  => Copy::server('VALIDATION_MAX_string'),
                'array'   => Copy::server('VALIDATION_MAX_array'),
            ],
            'mimes'                => Copy::server('VALIDATION_MIMES'),
            'mimetypes'            => Copy::server('VALIDATION_MIMETYPES'),
            'min'                  => [
                'numeric' => Copy::server('VALIDATION_MIN_NUMERIC'),
                'file'    => Copy::server('VALIDATION_MIN_FILE'),
                'string'  => Copy::server('VALIDATION_MIN_STRING'),
                'array'   => Copy::server('VALIDATION_MIN_ARRAY'),
            ],
            'not_in'               => Copy::server('VALIDATION_NOT_IN'),
            'numeric'              => Copy::server('VALIDATION_NUMERIC'),
            'present'              => Copy::server('VALIDATION_PRESENT'),
            'regex'                => Copy::server('VALIDATION_REGEX'),
            'required'             => Copy::server('VALIDATION_REQUIRED'),
            'required_if'          => Copy::server('VALIDATION_REQUIRED_IF'),
            'required_unless'      => Copy::server('VALIDATION_REQUIRED_UNLESS'),
            'required_with'        => Copy::server('VALIDATION_REQUIRED_WITH'),
            'required_with_all'    => Copy::server('VALIDATION_REQUIRED_WITH_ALL'),
            'required_without'     => Copy::server('VALIDATION_REQUIRED_WITHOUT'),
            'required_without_all' => Copy::server('VALIDATION_REQUIRED_WITHOUT_ALL'),
            'same'                 => Copy::server('VALIDATION_SAME'),
            'size'                 => [
                'numeric' => Copy::server('VALIDATION_SIZE_NUMERIC'),
                'file'    => Copy::server('VALIDATION_SIZE_FILE'),
                'string'  => Copy::server('VALIDATION_SIZE_STRING'),
                'array'   => Copy::server('VALIDATION_SIZE_ARRAY'),
            ],
            'string'               => Copy::server('VALIDATION_STRING'),
            'timezone'             => Copy::server('VALIDATION_TIMEZONE'),
            'unique'               => Copy::server('VALIDATION_UNIQUE'),
            'uploaded'             => Copy::server('VALIDATION_UPLOADED'),
            'url'                  => Copy::server('VALIDATION_URL'),
        ];
    }

    /**
     * Add a new input value.
     *
     * @param $key
     * @param $value
     */
    public function add($key, $value)
    {
        $request = $this->all();

        $request[$key] = $value;

        $this->replace($request);

        $this->request->replace($request);
    }

    /**
     * Replace an input value.
     *
     * @param $key
     * @param $value
     */
    public function set($key, $value)
    {
        $request = $this->all();

        $request[$key] = $value;

        $this->replace($request);
    }

    /**
     * Return the array with camelcase keys transformed to underscore.
     *
     * @param array $params
     *
     * @return array|string
     */
    public function params(...$params)
    {
        $request = $this->validated();

        if (! $params) {
            return camel_to_underscore($request, true);
        }

        $only = [];

        foreach ($params as $param) {
            if (isset($request[$param])) {
                $only[$param] = $request[$param];
            }
        }

        return camel_to_underscore($only, true) ?? null;
    }

    /**
     * @param $key
     *
     * @return array|mixed
     */
    public function swgArray($key)
    {
        $request = $this->get($key);

        return \is_string($request) ? explode(',', str_replace('"', '', $request)) : $request;
    }
}
