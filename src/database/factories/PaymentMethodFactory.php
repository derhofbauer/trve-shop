<?php

use Faker\Generator as Faker;

$factory->define(App\SysPaymentMethod::class, function (Faker $faker) {
    return [
        'data' => [
            'iban' => $faker->iban('AT'),
            'swift' => $faker->swiftBicNumber,
            'owner' => $faker->name
        ],
        'feuser_id' => 2
    ];
});
