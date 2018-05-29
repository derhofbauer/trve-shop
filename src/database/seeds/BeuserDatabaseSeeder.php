<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class BeuserDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run ()
    {
        \App\SysBeuser::create([
            'username' => 'ford',
            'email' => 'ford.prefect@galaxy.com',
            'password' => bcrypt('password'),
            'role_id' => 2
        ]);

        \App\SysBeuser::create([
            'username' => 'admin',
            'email' => 'arthur.dent@galaxy.com',
            'password' => bcrypt('password'),
            'role_id' => 1
        ]);
    }
}
