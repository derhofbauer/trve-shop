<?php

use Faker\Generator as Faker;

$factory->define(\App\SysOrder::class, function (Faker $faker) {

    $user = \App\SysFeuser::find(rand(1, 20));
    $products = \App\SysProduct::inRandomOrder()->limit(2)->get();

    $products_array = [];
    foreach ($products as $product) {
        $product = $product->toArray();
        $product['quantity'] = rand(1, 5);
        $products_array[] = $product;
    }

    return [
        'status' => rand(0, 2),
        'delivery_address' => $faker->address,
        'feuser_id' => $user->id,
        'payment_method' => $user->paymentMethods->first(),
        'invoice' => $products_array
    ];
});
