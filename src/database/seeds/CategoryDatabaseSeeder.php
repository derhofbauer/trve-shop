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
            'name' => 'Clothing',
            'description' => 'T-Shirts, Sweaters, Baseball Caps etc.'
        ]);
        $category->save();

        $category = new \App\SysProductCategory([
            'name' => 'Sticker & Patches',
            'description' => ''
        ]);
        $category->save();

        $category = new \App\SysProductCategory([
            'name' => 'Media',
            'description' => 'CDs, digital downloads etc.'
        ]);
        $category->save();
    }
}
