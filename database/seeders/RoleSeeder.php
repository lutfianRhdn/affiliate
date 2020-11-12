<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $adminRole = Role::create([
            'name' => 'admin',
            'slug' => '',
            'guard_name'=>'web',
            'created_at' => now()
            ]);
           $resellerRole= Role::create([
                'name' => 'reseller',
                'slug' => '',
                'guard_name'=>'web',
            'created_at' => now()
        ]);
        $adminRole->syncPermissions(Permission::all());

    }
}
