<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'product_name' => 'PAGII',
            'description' => 'Pagii Apps',
            'regex' => 'PAGII',
            'created_at' => now()
        ]);
        
        DB::table('products')->insert([
            'product_name' => 'MARS',
            'description' => 'Mars Apps',
            'regex' => 'MARS',
            'created_at' => now()
        ]);
    }
}
