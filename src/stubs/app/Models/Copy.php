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
     * @param bool $server
     * @param string $key
     * @param string ...$params
     * @return mixed
     */
    private static function translate(bool $server, string $key, string ...$params)
    {
        $copy = Copy::where([
            'key'    => $key,
            'server' => $server
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
        return Copy::translate(true, $key, ...$params);
    }

    /**
     * Return the translation for a client key
     * @param $key
     * @param string[] $params
     * @return string
     */
    public static function client($key, string ...$params)
    {
        return Copy::translate(false, $key, ...$params);
    }

    /**
     * Return the translations for all the client/server keys
     * @param bool $server
     * @return mixed
     */
    public static function getTranslations(bool $server)
    {
        $copies = Copy::where(['server' => $server])->pluck(Headers::getLanguage(), 'key');

        return $copies->map(function ($item) {
            return self::scapeNewLine($item);
        });
    }

    /**
     * Return the translations for all the server keys
     */
    public static function serverTranslations()
    {
        return self::getTranslations(true);
    }

    /**
     * Return the translations for all the client keys
     */
    public static function clientTranslations()
    {
        return self::getTranslations(false);
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
     */
    public static function updateLanguages()
    {
        $languages = Config::languages();

        foreach ($languages as $language) {
            Copy::addColumn($language, 'longText', ['after' => 'en', 'nullable' => true]);
        }

        $except = array_merge(API_DEFAULT_LANGUAGES, ['id', 'key', 'server', 'created_at', 'updated_at']);

        $columnsToDrop = array_diff(self::getColumns(), $except);

        foreach ($columnsToDrop as $column) {

            if (!in_array($column, $languages) && !in_array($column, $except)) {
                self::dropColumn($column);
            }
        }
    }

    /**
     * Return a client/server key translated into all languages
     * @param bool $server
     * @param string $key
     * @param string[] $params
     * @return array
     */
    private static function inAllLanguages(bool $server, string $key, string ...$params)
    {
        $copies = [];

        foreach (Config::languages() as $language) {
            self::$language = $language;
            $copies[$language] = $server ? Copy::server($key, ...$params) : Copy::client($key, ...$params);
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
        return Copy::inAllLanguages(true, $key, ...$params);
    }

    /**
     * Return a client key translated into all languages
     * @param string $key
     * @param string ...$params
     * @return array
     */
    public static function clientInAllLanguages(string $key, string ...$params)
    {
        return Copy::inAllLanguages(false, $key, ...$params);
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
}
