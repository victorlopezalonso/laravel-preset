<?php

namespace App\Classes;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

class Console extends Command
{

    /**
     * Execute the commands passed to the function prefixing the project path
     *
     * @param array|string $commands
     * @return string
     */
    public static function exec($commands)
    {
        $commands = is_array($commands) ? implode(' && ', $commands) : implode(self::multiexplode($commands));
        $path     = base_path();

        $command = "cd $path && " . $commands;

        echo $command . PHP_EOL;

        return system($command);
    }

    /**
     * Update the value of an environment variable in the .env file
     *
     * @param $key
     * @param $newValue
     * @param null $environment
     */
    public static function setEnvironmentValue($key, $newValue, $environment = null)
    {
        $environment = $environment ? '.' . $environment : null;

        $envFile = App::environmentFilePath() . ($environment);

        putenv("{$key}={$newValue}");

        file_put_contents($envFile, preg_replace("/{$key}=(.*)/", "{$key}={$newValue}", file_get_contents($envFile)));
    }

    /**
     * Update the .env file from an array of $key => $value pairs.
     *
     * @param  array $updatedValues
     * @return void
     */
    public static function updateEnvironmentFile($updatedValues)
    {
        foreach ($updatedValues as $key => $value) {
            self::setEnvironmentValue($key, $value);
        }
    }

    /**
     * Make an artisan call and echo the output
     *
     * @param $command
     * @param array $params
     */
    public static function artisan($command, $params = [])
    {
        Artisan::call($command, $params);
        echo Artisan::output();
    }

    /**
     * App is in local or develop environment
     * @return bool
     */
    public static function isDevelopment()
    {
        $developEnvs = [LOCAL_ENVIRONMENT, DEVELOPMENT_ENVIRONMENT];

        return in_array(env('APP_ENV'), $developEnvs);
    }

    /**
     * .env file exists
     * @return bool
     */
    public static function envExists()
    {
        return ! ! env('APP_ENV');
    }

    /**
     * Return a string as an array using delimiters
     * @param $string
     * @param $delimiters
     * @return array
     */
    private static function multiexplode($string, $delimiters = [',', '|', ':'])
    {
        $replace = str_replace($delimiters, $delimiters[0], $string);

        return explode($delimiters[0], $replace);
    }

    /**
     * @return mixed
     */
    public static function deploy()
    {
        if (intval(env('DEPLOY_MODE')) === WEBHOOK_DEPLOY) {
            Console::setEnvironmentValue('DEPLOY', 1);
        }

        return env('DEPLOY');
    }

    /**
     * Add the web routes from the Routes/Web directory
     */
    public static function addWebRoutes()
    {
        // Include all files within the App/Routes/Web directory
        foreach (File::allFiles(app()->path() . '/Routes/Web') as $route) {
            require_once $route->getPathname();
        }
    }

    /**
     * Add the admin routes from the Routes/Web directory
     */
    public static function addAdminRoutes()
    {
        Route::group(['namespace' => 'Admin', 'middleware' => 'auth.admin'], function () {
            foreach (File::allFiles(app()->path() . '/Routes/Admin') as $route) {
                require_once $route->getPathname();
            }
        });
    }
}