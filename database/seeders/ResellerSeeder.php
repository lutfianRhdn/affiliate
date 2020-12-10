<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ResellerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          // reseller
          $resellerPagii = User::create([
            'name'=>'reseller pagii',
            'email' =>'reseller@pagii.com',
            'phone'=>'081234567891',
            'password'=>Hash::make('password'),
            'product_id'=> Product::where('product_name','pagii')->first()->id,
            'company_id'=>Company::where('name','affiliate')->first()->id,
            'ref_code' => 'PAGII-A1B2C3',
            'register_status'=>1,
            'address'=>'Jl. Holis Regency No.37A, Babakan, Babakan Ciparay',
            'approve'=>1,
            'status'=>1
        ]);
        $resellerPagii->assignRole('reseller','reseller-affiliate');
    }
}
