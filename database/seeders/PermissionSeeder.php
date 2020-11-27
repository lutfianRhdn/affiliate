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
            'role','user','product'
        ];
        $actions = [
            'view','create','edit','delete'
        ];
        foreach ($permissions as $permission) {
            foreach ($actions as $action) {
                    Permission::create(['name'=>$permission.'.'.$action]);
            }
        }
    }
}
