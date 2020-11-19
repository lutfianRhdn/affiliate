<?php

namespace Database\Seeders;

use App\Models\Product;
use Vinkla\Hashids\Facades\Hashids;
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
        $pagii = Product::create([
            'product_name' => 'PAGII',
            'description' => 'Pagii Apps',
            'regex' => 'PAGII',
            'permission_ip'=> 'http://intern-pagii.smtapps.net/',
            'url'=>'http://pagii.co',
            'created_at' => now()
        ]);
        $id = Hashids::encode($pagii->id);
        $pagii->code = view('pages.register_embed',compact('id'))->render();
        $pagii->save();
       $mars = Product::create([
            'product_name' => 'MARS',
            'description' => 'Mars Apps',
            'regex' => 'MARS',
            'permission_ip'=>'http://mars.co',
            'url'=> 'http://mars.co',
            'created_at' => now()
        ]);
        $id = Hashids::encode($mars->id); 
        $mars->code = view('pages.register_embed',compact('id'))->render();
        $mars->save();
    }
}
