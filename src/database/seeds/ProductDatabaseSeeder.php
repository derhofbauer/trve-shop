<?php

use Illuminate\Database\Seeder;

class ProductDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Product 1',
                'description' => 'Product 1 Description',
                'price' => 15.99,
                'stock' => 100,
                'media' => null,
                'parent_product_id' => null,
            ],
            [
                'name' => 'Product 2',
                'description' => 'Product 2 Description',
                'price' => 42,
                'stock' => 5,
                'media' => null,
                'parent_product_id' => null,
            ],
            [
                'name' => 'Product 1.1',
                'description' => 'Product 1.1 Description',
                'price' => 6.66,
                'stock' => 5,
                'media' => null,
                'parent_product_id' => 1,
            ],
        ];

        foreach ($data as $date) {
            $product = new \App\SysProduct($date);
            $product->save();
        }
    }
}
