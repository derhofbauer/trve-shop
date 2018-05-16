<?php

use Illuminate\Database\Seeder;

class SysRoleDatabaseSeeder extends Seeder
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
            'name' => 'Just a user',
            'description' => 'Allowed to do nothing :('
        ];

        foreach ($permissions as $permission) {
            $values1[$permission] = true;
            $values2[$permission] = false;
        }

        DB::table('sys_role')->insert($values1);
        DB::table('sys_role')->insert($values2);
    }
}
