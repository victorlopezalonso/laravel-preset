<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Copy::class, function (Faker $faker) {

    $copy['key'] = microtime(true);
    $copy['type'] = SERVER_COPY;

    foreach (\App\Models\Config::languages() as $language) {
        $copy[$language] = $faker->text();
    }

    return $copy;
});
