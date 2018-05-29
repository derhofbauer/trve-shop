<?php

use Faker\Generator as Faker;

$factory->define(App\SysAddress::class, function (Faker $faker) {
    return [
        'country' => $faker->country,
        'city' => $faker->city,
        'zip' => $faker->randomDigit,
        'street' => $faker->streetName,
        'street_number' => $faker->randomDigit,
        'address_line_2' => $faker->streetAddress,
        'feuser_id' => 2
    ];
});
