<?php

use Faker\Generator as Faker;

$factory->define(\App\SysBlogEntry::class, function (Faker $faker) {
    return [
        'title' => $faker->text('50'),
        'abstract' => $faker->text('300'),
        'content' => $faker->text('10000'),
        'beuser_id' => rand(1, 2),
        'media' => [
            "public/blog_pictures/28471925_1629535930460478_1366439485830594560_o.jpg",
            "public/blog_pictures/28511600_1625606160853455_897929178_n.jpg",
            "public/blog_pictures/28576275_1629535980460473_3249609368966004736_o.jpg",
        ]
    ];
});
