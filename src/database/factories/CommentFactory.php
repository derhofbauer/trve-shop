<?php

use Faker\Generator as Faker;

$factory->define(\App\SysComment::class, function (Faker $faker) {
    return [
        'feuser_id' => rand(1, 20),
        'product_id' => rand(1, 8),
        'content' => $faker->text(500)
    ];
});
