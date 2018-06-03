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
        factory(App\SysOrder::class, 50)->create();
    }
}
