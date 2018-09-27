<?php

namespace App\Http\Requests;

use App\Models\Config;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

/**
 * Class Headers
 * @package App\Http\Requests
 */
class Headers
{

    /**
     * Return the headers sent to the service as an array
     * @return array
     */
    public static function asArray()
    {
        return [
            API_KEY_HEADER     => self::getApiKey(),
            LANGUAGE_HEADER    => self::getLanguage(),
            OS_HEADER          => self::getOs(),
            APP_VERSION_HEADER => self::getAppVersion()
        ];
    }

    /**
     * Return the apikey header param
     * @return string
     */
    public static function getApiKey()
    {
        return request()->header(API_KEY_HEADER);
    }

    /**
     * Return the language header param
     * @return string
     */
    public static function getLanguage()
    {
        $language = request()->header(LANGUAGE_HEADER);

        if ( ! $language || ! in_array($language, Config::languages())) {
            return API_DEFAULT_LANGUAGE;
        }

        return $language;
    }

    /**
     * Return the appVersion header param
     * @return string
     */
    public static function getAppVersion()
    {
        return request()->header(APP_VERSION_HEADER) ?? '0.0.0';
    }

    /**
     * Return the os header param
     * @return string
     */
    public static function getOs()
    {
        return request()->header(OS_HEADER);
    }

    /**
     * Check if the os is Android
     * @return bool
     */
    public static function isAndroid()
    {
        return request()->header(OS_HEADER) === ANDROID_OS_DESCRIPTION;
    }

    /**
     * Check if the os is iOS
     * @return bool
     */
    public static function isIos()
    {
        return request()->header(OS_HEADER) === IOS_OS_DESCRIPTION;
    }

    /**
     * Return the os param as an integer
     * @return int|null
     */
    public static function getOsAsInteger()
    {
        if (self::isAndroid()) {
            return ANDROID_OS;
        } elseif (self::isIos()) {
            return IOS_OS;
        }

        return OTHER_OS;
    }

    /**
     * Check the required headers
     * @throws \Throwable
     */
    public static function checkHeaders()
    {
        if ( ! CHECK_HEADERS_MIDDLEWARE) {
            return;
        }

        $validator = Validator::make(self::asArray(), [
            API_KEY_HEADER     => ['required', Rule::in([env('APP_KEY')])],
            OS_HEADER          => ['required', Rule::in([ANDROID_OS_DESCRIPTION, IOS_OS_DESCRIPTION])],
            APP_VERSION_HEADER => 'required',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }


}
