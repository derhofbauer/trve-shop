<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
                factory(App\User::class)->make()
        );

        DB::table('users')->insert([
                'name' => 'admin',
                'email' => 'arthur.dent@galaxy.com',
                'password' => bcrypt('password')
        ]);
    }
}
