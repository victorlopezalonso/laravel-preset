<?php

namespace App\Models;

use App\Http\Requests\Headers;
use Carbon\Carbon;

/**
 * Contains all the translations for both server and client side
 * @package App\Models
 */
class Copy extends ApiModel
{
    protected static $language = null;

    /**
     * Return the translation for a server/client key
     * @param int $type
     * @param string $key
     * @param string ...$params
     * @return mixed
     */
    private static function translate(int $type, string $key, string ...$params)
    {
        $copy = Copy::where([
            'key'    => $key,
            'type' => $type
        ])->pluck(self::$language ?? Headers::getLanguage())->first();

        if (!$copy) {
            return '';
        }

        $count = 1;
        foreach ($params as $param) {
            $copy = str_replace("%$count", $param, $copy);
            $count++;
        }

        return self::scapeNewLine($copy);
    }

    /**
     * Return the translation for a server key
     * @param $key
     * @param string[] $params
     * @return string
     */
    public static function server($key, string ...$params)
    {
        return Copy::translate(SERVER_COPY, $key, ...$params);
    }

    /**
     * Return the translation for a client key
     * @param $key
     * @param string[] $params
     * @return string
     */
    public static function client($key, string ...$params)
    {
        return Copy::translate(CLIENT_COPY, $key, ...$params);
    }

    /**
     * Return the translation for an admin key
     * @param $key
     * @param string[] $params
     * @return string
     */
    public static function admin($key, string ...$params)
    {
        return Copy::translate(ADMIN_COPY, $key, ...$params);
    }

    /**
     * Return the translations for all the client/server keys
     * @param int $type
     * @return mixed
     */
    public static function getTranslations(int $type)
    {
        $copies = Copy::where(['type' => $type])->pluck(Headers::getLanguage(), 'key');

        return $copies->map(function ($item) {
            return self::scapeNewLine($item);
        });
    }

    /**
     * Return the translations for all the server keys
     */
    public static function serverTranslations()
    {
        return self::getTranslations(SERVER_COPY);
    }

    /**
     * Return the translations for all the client keys
     */
    public static function clientTranslations()
    {
        return self::getTranslations(CLIENT_COPY);
    }

    /**
     * Return the translations for all the client keys
     */
    public static function adminTranslations()
    {
        return self::getTranslations(ADMIN_COPY);
    }

    /**
     * Return new line characters with one backslash
     * @param $string
     * @return mixed
     */
    public static function scapeNewLine($string)
    {
        return str_replace("\\n", "\n", $string);
    }

    /**
     * Datetime of the last modification
     * @return Carbon
     */
    public static function lastUpdate()
    {
        return Copy::select('updated_at')->orderBy('updated_at', 'desc')->first()->updated_at;
    }

    /**
     * Update the columns of the table copies with the existing languages in the configuration
     * @param bool $delete
     */
    public static function updateLanguages(bool $delete = false)
    {
        $languages = Config::languages();
        
        foreach ($languages as $language) {
            Copy::addColumn($language, 'longText', ['after' => 'en', 'nullable' => true]);
        }

        if ($delete) {
            $except = array_merge(API_DEFAULT_LANGUAGES, ['id', 'key', 'type', 'created_at', 'updated_at']);

            $columnsToDrop = array_diff(self::getColumns(), $except);

            foreach ($columnsToDrop as $column) {

                if (!in_array($column, $languages) && !in_array($column, $except)) {
                    self::dropColumn($column);
                }
            }
        }
    }

    /**
     * Return a client/server key translated into all languages
     * @param int $type
     * @param string $key
     * @param string[] $params
     * @return array
     */
    private static function inAllLanguages(int $type, string $key, string ...$params)
    {
        $copies = [];

        foreach (Config::languages() as $language) {
            self::$language = $language;
            switch ($type){
                case CLIENT_COPY:
                    $copies[$language] = Copy::client($key, ...$params);
                    break;
                case SERVER_COPY:
                    $copies[$language] = Copy::server($key, ...$params);
                    break;
                case ADMIN_COPY:
                    $copies[$language] = Copy::admin($key, ...$params);
                    break;
            }
            $copies[$language] = $type ? Copy::server($key, ...$params) : Copy::client($key, ...$params);
        }

        return $copies;
    }

    /**
     * Return a server key translated into all languages
     * @param string $key
     * @param string ...$params
     * @return array
     */
    public static function serverInAllLanguages(string $key, string ...$params)
    {
        return Copy::inAllLanguages(SERVER_COPY, $key, ...$params);
    }

    /**
     * Return a client key translated into all languages
     * @param string $key
     * @param string ...$params
     * @return array
     */
    public static function clientInAllLanguages(string $key, string ...$params)
    {
        return Copy::inAllLanguages(CLIENT_COPY, $key, ...$params);
    }

    /**
     * Return an admin key translated into all languages
     * @param string $key
     * @param string ...$params
     * @return array
     */
    public static function adminInAllLanguages(string $key, string ...$params)
    {
        return Copy::inAllLanguages(ADMIN_COPY, $key, ...$params);
    }

    public static function createFromObject($get, $keyname = null)
    {
        $copy['key'] = $keyname . '_' . microtime(true);

        foreach ($get as $key => $value) {
            $copy[$key] = $value;
        }

        Copy::create($copy);

        return $copy['key'];
    }

    /**
     * @param array $params
     * @param int $type
     * @return Copy
     */
    public static function createWithUniqueKey(array $params, int $type = SERVER_COPY)
    {
        return Copy::create(array_merge(['key' => microtime(true), 'type' => $type], $params));
    }

    /**
     * @param array $params
     * @param null $key
     * @return mixed
     */
    public static function updateByKey($params, $key = null)
    {
        if (isset($params['id'])) {
            unset($params['id']);
        }

        return Copy::where('key', $key ?? $params['key'])->update($params);
    }
}
