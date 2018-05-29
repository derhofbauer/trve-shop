<?php

use Illuminate\Database\Seeder;

class PaymentMethodDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\SysPaymentMethod::class, 20)->create();
    }
}
