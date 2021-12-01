<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $modules = ['users', 'leads', 'clients', 'companies'];

        foreach ($modules as $module) {
            DB::table('permissions')->insert(['name' => $module . ' search', 'slug' => $module . '-search']);
            DB::table('permissions')->insert(['name' => $module . ' export pdf', 'slug' => $module . '-export-pdf']);
            DB::table('permissions')->insert(['name' => $module . ' find', 'slug' => $module . '-find']);
            DB::table('permissions')->insert(['name' => $module . ' update', 'slug' => $module . '-update']);
            DB::table('permissions')->insert(['name' => $module . ' delete', 'slug' => $module . '-delete']);
            DB::table('permissions')->insert(['name' => $module . ' create', 'slug' => $module . '-create']);
        }

        DB::table('roles')->insert([
            'name' => 'admin',
            'slug' => 'admin'
        ]);

        for ($i=1; $i < (count($modules) * 6 + 1); $i++) {
            DB::table('roles_permissions')->insert([
                'permission_id' => $i,
                'role_id' => 1
            ]);
        }

        DB::table('users_roles')->insert([
            'user_id' => 1,
            'role_id' => 1
        ]);
    }
}
