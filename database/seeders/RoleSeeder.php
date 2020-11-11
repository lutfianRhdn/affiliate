<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'admin',
            'slug' => '',
            'guard_name'=>'web',
            'created_at' => now()
            ]);
            DB::table('roles')->insert([
                'name' => 'reseller',
                'slug' => '',
                'guard_name'=>'web',
            'created_at' => now()
        ]);
    }
}
