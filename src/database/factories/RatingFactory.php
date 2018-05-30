<?php

use Faker\Generator as Faker;

$factory->define(\App\SysRating::class, function (Faker $faker) {
    return [
        'feuser_id' => rand(1, 15),
        'product_id' => rand(1, 8),
        'rating' => rand(1, 5)
    ];
});
