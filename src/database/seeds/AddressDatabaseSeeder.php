<?php

use Illuminate\Database\Seeder;

class AddressDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\SysAddress::class, 20)->create();
    }
}
