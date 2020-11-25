<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminAffiliate = Company::create([
            'name'=> 'admin affiliate',
            'email'=> 'admin@affiliate.com',
            'company_name'=>'affiliate',
            'phone'=> '08123456789',
            'password'=>Hash::make('admin1234'),
            'is_active' =>1,
            'approve' =>1
        ]);
        $adminPagii = Company::create([
            'name'=> 'admin pagii',
            'email'=> 'admin@pagii.com',
            'company_name'=>'pagii',
            'phone'=> '08123456789',
            'password'=>Hash::make('admin1234'),
            'is_active'=> 1,
            'approve'=> 1
        ]);
        $adminAffiliate->assignRole('admin-company');
        $adminPagii->assignRole('admin-company');

    }
}
