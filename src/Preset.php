<?php

namespace Quadram\LaravelPreset;

use Illuminate\Foundation\Console\Presets\Preset as LaravelPreset;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;

class Preset extends LaravelPreset
{

    public static function install()
    {
        static::updatePackages();

        static::updatePackageScripts();

        static::updateComposer();

        static::copyFilesAndDirectories();

        static::compileFront();
    }

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

    public static function updatePackageArray($packages)
    {
        $includedPackages = [
            'bulma'			=> '^0.6.2',
            'chart.js'		=> '2.7.1',
            'vue-router'	=> '^3.0.1',
            "vuejs-dialog"	=> "^1.3.0"
        ];
        $excludedPackages = [
            'bootstrap',
            'jquery',
            'lodash',
            'popper.js',
        ];

        return array_merge($includedPackages, Arr::except($packages, $excludedPackages));
    }

    public static function updateJsonFile($file, $add = [])
    {
        $json = json_decode(file_get_contents($file), true);

        foreach ($add as $key => $value) {
            $json[$key] = array_merge($json[$key], $value);
        }

        ksort($json['scripts']);

        file_put_contents($file, json_encode($json, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . PHP_EOL);
    }

    public static function updateComposer()
    {
        self::exec("composer require laravel/passport doctrine/dbal intervention/image phpoffice/phpspreadsheet darkaonline/l5-swagger zircote/swagger-php '2.*'");
        //system("composer require 'zircote/swagger-php:2.*'");

        $composer['autoload'] = [
            'files' => ["app/Helpers/Helpers.php"]
        ];

        static::updateJsonFile(base_path('composer.json'), $composer);
    }

    public static function updatePackageScripts()
    {
        $package['scripts'] = [
            'laravel-init' => 'composer install; php artisan laravel:create-env-file; php artisan laravel:init; php artisan laravel:info',
            'test'         => 'vendor/bin/phpunit --filter',
            'tests'        => 'vendor/bin/phpunit',
            'jobs'         => 'php artisan queue:work --tries=3',
        ];

        static::updateJsonFile(base_path('package.json'), $package);
    }

    public static function copyFilesAndDirectories()
    {
        $files = [
            '/stubs/.env.example' => base_path('.env.example'),
            '/stubs/.gitignore'   => base_path('.gitignore'),
            '/stubs/swagger.php'  => app_path('swagger.php'),
            '/stubs/.php_cs'      => base_path('.php_cs'),
        ];

        $directories = [
            '/stubs/app'           => app_path(),
            '/stubs/config'        => config_path(),
            '/stubs/database'      => base_path('/database'),
            '/stubs/routes'        => base_path('/routes'),
            '/stubs/tests'         => base_path('/tests'),
            '/stubs/public/images' => base_path('/public/images'),
            '/stubs/resources'     => base_path('/resources'),
        ];

        foreach ($directories as $origin => $destination) {
            File::copyDirectory(__DIR__ . $origin, $destination);
        }

        foreach ($files as $origin => $destination) {
            copy(__DIR__ . $origin, $destination);
        }

    }

    public static function compileFront()
    {
        self::exec('npm install');
        
        self::exec('npm run dev');
    }
}