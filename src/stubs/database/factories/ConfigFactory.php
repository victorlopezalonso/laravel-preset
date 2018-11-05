<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Config::class, function (Faker $faker) {

    foreach (API_DEFAULT_LANGUAGES as $language) {
        $languages[] = $language;
    }

    return [
        'android_version' => '1',
        'ios_version'     => '0.0.1',
        'languages'       => $languages ?? null
    ];

});
