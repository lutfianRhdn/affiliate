<?php

namespace Database\Seeders;

use App\Models\Company;
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
       $superAdminRole = Role::create([
            'name' => 'super-admin',
            'slug' => '',
            'guard_name'=>'web',
            'created_at' => now()
            ]);
        $admin = Role::create([
                'name'=>'admin',
                'slug' => '',
                'guard_name' => 'web',
                'created_at' => now()
            ]);
        $admin = Role::create([
                'name'=>'super-admin-company',
                'slug' => '',
                'guard_name' => 'web',
                'created_at' => now()
            ]);
     
           $reseller= Role::create([
                'name' => 'reseller',
                'slug' => '',
                'guard_name'=>'web',
            'created_at' => now()
        ]);
           
        $superAdminRole->syncPermissions(Permission::all());
    }
}
