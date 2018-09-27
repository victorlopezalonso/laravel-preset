<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Notification::class, function (Faker $faker) {

    $languages = \App\Models\Config::languages();

    foreach ($languages as $language) {
        $title[$language]   = $faker->text(30);
        $header[$language]  = $faker->text(50);
        $content[$language] = $faker->text;
    }

    return [
        'title'   => $title,
        'header'  => $header,
        'content' => $content,
    ];
});
