<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run ()
    {
        $this->call([
            RoleDatabaseSeeder::class,
            BeuserDatabaseSeeder::class,
            FeuserDatabaseSeeder::class,
            ProductDatabaseSeeder::class,
            BlogEntryDatabaseSeeder::class,
            CategoryDatabaseSeeder::class,
            CommentDatabaseSeeder::class,
            OrderDatabaseSeeder::class,
            AddressDatabaseSeeder::class,
            PaymentMethodDatabaseSeeder::class
        ]);
    }
}
