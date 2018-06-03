<?php

use Illuminate\Database\Seeder;

class CommentDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run ()
    {
        factory(\App\SysComment::class, 20)->create();
        factory(\App\SysRating::class, 20)->create();
    }
}
