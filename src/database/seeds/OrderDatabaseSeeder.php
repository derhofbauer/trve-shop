<?php

use Illuminate\Database\Seeder;

class OrderDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $order = new \App\SysOrder([
            'feuser_id' => 1
        ]);
        $order->save();

        $productMM = new \App\SysOrderProductMM([
            'product_id' => 1,
            'product_quantity' => 2,
            'order_id' => 1
        ]);
        $productMM->save();
    }
}
