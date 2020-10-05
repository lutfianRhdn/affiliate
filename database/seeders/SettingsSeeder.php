<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            'key' => 'key',
            'label' => 'percentage',
            'value' => '10',
            'group' => 'admin',
            'created_at' => now()
        ]);
    }
}
