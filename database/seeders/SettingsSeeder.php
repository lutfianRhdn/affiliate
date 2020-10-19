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
        DB::table('settings')->where('id', 1)->update([
            'key' => 'percentage',
            'label' => 'Percentage',
            'value' => '10',
            'product_name' => 'Pagii',
            'group' => 'admin',
            'updated_at' => now()
        ]);
        DB::table('settings')->insert([
            'key' => 'penarikan/kalkulasi',
            'label' => 'Penarikan/Kalkulasi',
            'value' => '20',
            'product_name' => 'Pagii',
            'group' => 'admin',
            'created_at' => now()
        ]);
        DB::table('settings')->insert([
            'key' => 'commision',
            'label' => 'Commision',
            'value' => '2',
            'product_name' => 'Pagii',
            'group' => 'admin',
            'created_at' => now()
        ]);
    }
}
