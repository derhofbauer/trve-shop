<?php

use Faker\Generator as Faker;

$factory->define(\App\SysBlogEntry::class, function (Faker $faker) {
    return [
        'title' => $faker->text('50'),
        'abstract' => $faker->text('300'),
        'content' => $faker->text('10000'),
        'media' => [$faker->image()],
        'beuser_id' => 2
    ];
});
