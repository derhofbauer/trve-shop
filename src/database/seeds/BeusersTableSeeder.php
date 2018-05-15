<?php

use Illuminate\Database\Seeder;

class BeusersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sys_beusers')->insert([
                'name' => 'ford',
                'email' => 'ford.prefect@galaxy.com',
                'password' => bcrypt('password'),
                'role_uid' => 1
        ]);

        DB::table('sys_beusers')->insert([
                'name' => 'admin',
                'email' => 'arthur.dent@galaxy.com',
                'password' => bcrypt('password'),
                'role_uid' => 1
        ]);
    }
}
