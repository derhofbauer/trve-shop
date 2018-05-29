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
            CategoryDatabaseSeeder::class,
            ProductDatabaseSeeder::class,
            BlogEntryDatabaseSeeder::class,
            CommentDatabaseSeeder::class,
            OrderDatabaseSeeder::class,
            AddressDatabaseSeeder::class,
            PaymentMethodDatabaseSeeder::class
        ]);
    }
}
