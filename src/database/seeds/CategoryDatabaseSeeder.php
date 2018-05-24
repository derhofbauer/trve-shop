<?php

use Illuminate\Database\Seeder;

class CategoryDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = new \App\SysProductCategory([
            'name' => 'category 1',
            'description' => 'description 1'
        ]);
        $category->save();

        $category = new \App\SysProductCategory([
            'name' => 'category 2',
            'description' => 'description 2'
        ]);
        $category->save();
    }
}
