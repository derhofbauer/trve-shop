<?php

use Illuminate\Database\Seeder;

class RoleDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = \App\SysRole::getPermissions();
        $values1 = [
            'name' => 'Super Admin',
            'description' => 'Allowed to do everything! :D'
        ];
        $values2 = [
            'name' => 'Blog Editor',
            'description' => 'Allowed to edit blog'
        ];
        $values3 = [
            'name' => 'Warehouse Worker',
            'description' => 'Allowed to edit products'
        ];

        foreach ($permissions as $permission) {
            $values1[$permission] = true;
            $values2[$permission] = false;
            $values3[$permission] = false;
        }

        DB::table('sys_role')->insert($values1);
        DB::table('sys_role')->insert($values2);
        DB::table('sys_role')->insert($values3);
    }
}
