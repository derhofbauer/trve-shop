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
        $permissions = CreateSysRoleTable::getPermissions();
        $values = [
            'name' => 'Super Admin',
            'description' => 'Allowed to do everything! :D'
        ];

        foreach ($permissions as $permission) {
            $values[$permission] = true;
        }

        DB::table('sys_role')->insert($values);
    }
}
