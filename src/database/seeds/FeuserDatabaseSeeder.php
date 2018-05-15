<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class FeuserDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sys_feusers')->insert([
            'email' => 'ford.prefect@galaxy.com',
            'password' => bcrypt('password'),
            'firstname' => 'Ford',
            'lastname' => 'Prefect',
            'title' => 'Sir'
        ]);

        DB::table('sys_feusers')->insert([
            'email' => 'arthur.dent@galaxy.com',
            'password' => bcrypt('password'),
            'firstname' => 'Arthur',
            'lastname' => 'Dent',
            'title' => 'Dr.'
        ]);
    }
}
