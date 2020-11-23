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
       $adminRole = Role::create([
            'name' => 'super-admin',
            'slug' => '',
            'guard_name'=>'web',
            'created_at' => now()
            ]);
        $admin = Role::create([
                'name'=>'admin',
                'slug' => '',
                'company_id'=>Company::where('name','affiliate')->get()->first()->id,
                'guard_name' => 'web',
                'created_at' => now()
            ]);
           $resellerRole= Role::create([
                'name' => 'reseller',
                'slug' => '',
                'company_id' => Company::where('name', 'affiliate')->get()->first()->id,
                'guard_name'=>'web',
            'created_at' => now()
        ]);
        $adminRole->syncPermissions(Permission::all());
    }
}
