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
    public function run()
    {
        DB::table('sys_beusers')->insert([
                'username' => 'ford',
                'email' => 'ford.prefect@galaxy.com',
                'password' => bcrypt('password'),
                'role_id' => 1
        ]);

        DB::table('sys_beusers')->insert([
                'username' => 'admin',
                'email' => 'arthur.dent@galaxy.com',
                'password' => bcrypt('password'),
                'role_id' => 1
        ]);
    }
}
