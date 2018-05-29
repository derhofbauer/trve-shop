<?php

use Illuminate\Database\Seeder;

class BlogEntryDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\SysBlogEntry::class, 20)->create();

        foreach (\App\SysBlogEntry::all() as $entry) {
            $entry->products()->attach([
                rand(1,8),
                rand(1,8)
            ]);
        }
    }
}
