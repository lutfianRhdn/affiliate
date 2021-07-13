<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions= [
            'role','admin','company','reseller','product','setting','log'
        ];
        $actions = [
            'view','create','edit','delete'
        ];
        foreach ($permissions as $permission) {
            foreach ($actions as $action) {
                    Permission::create(['name'=>$permission.'.'.$action]);
            }
        }
        Permission::create(['name'=>'company.approve']);
        Permission::create(['name'=>'reseller.approve']);
    }
}
