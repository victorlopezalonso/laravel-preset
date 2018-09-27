<?php

namespace App\Models;

use App\Http\Requests\Headers;
use Carbon\Carbon;

class Config extends ApiModel
{

    protected $casts = [
        'app_in_maintenance' => 'boolean',
        'languages'          => 'array',
    ];

    /**
     * App in maintenance as boolean
     * @return bool
     */
    public function appIsInMaintenance()
    {
        return $this->app_in_maintenance;
    }

    /**
     * Return the languages as an array
     * @return array
     */
    public static function languages()
    {
        return Config::first()->languages;
    }

    /**
     * Return the last timestamp when the copies were updated
     * @return string
     */
    public function copiesUpdatedAt()
    {
        return Copy::lastUpdate()->toDateTimeString();
    }

    /**
     * Return if the version passed as header is outdated
     * @return bool
     */
    public function appVersionIsOutdated()
    {
        $appVersion = '0.0.1';

        if (Headers::isAndroid()) {
            $appVersion = $this->android_version;
        } elseif (Headers::isIos()) {
            $appVersion = $this->ios_version;
        }

        return version_compare(Headers::getAppVersion(), $appVersion) == -1 ? true : false;
    }

    /**
     * Return all the client localized copies
     * @return Copy[]|null
     */
    public function localizedCopies()
    {
        if ($this->appIsInMaintenance() || $this->appVersionIsOutdated()) {
            return null;
        }

        if ( ! request('copiesUpdatedAt')) {
            return Copy::clientTranslations();
        }

        $requestCopiesUpdatedAt = Carbon::createFromFormat('Y-m-d H:i:s', request('copiesUpdatedAt'));

        return Copy::lastUpdate()->greaterThan($requestCopiesUpdatedAt) ? Copy::clientTranslations() : null;
    }

    /**
     * Return the localized languages of the app as an array with the format key => value
     * @return array
     */
    public function localizedLanguages()
    {
        foreach (self::languages() as $language) {
            $appLanguages[$language] = Copy::server(LANGUAGES[$language] ?? '');
        }

        return $appLanguages ?? null;
    }

    /**
     * Return a list of localized languages as an array with the structure for a multi-check vue component
     * @return array
     */
    public static function languagesForAdmin()
    {
        $copies = Copy::serverTranslations();

        $languages = self::languages();

        foreach (LANGUAGES as $key => $value) {
            $localized[] = [
                'key'     => $key,
                'value'   => $copies[$value] ?? $value,
                'checked' => in_array($key, $languages)
            ];
        }

        return $localized ?? null;
    }
}
