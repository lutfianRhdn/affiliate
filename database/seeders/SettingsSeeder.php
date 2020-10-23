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
            'product_id' => '1',
            'group' => 'admin',
            'updated_at' => now()
        ]);
        DB::table('settings')->where('id', 2)->update([
            'key' => 'day of settelment',
            'label' => 'Day of Settelment',
            'value' => '20',
            'product_id' => '1',
            'group' => 'admin',
            'updated_at' => now()
        ]);
    }
}
