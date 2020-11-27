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
            'name'=> 'Affiliate',
        ]);
        $adminPagii = Company::create([
            'name'=> 'Pagii',
        ]);

    }
}
