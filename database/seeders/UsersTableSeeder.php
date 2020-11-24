<?php
namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $user = User::create([
        // 'name' => 'Admin Affiliate',
        // 'email' => 'admin@affiliate.com',
        // 'role' => '1',
        // 'phone' => '08123456789',
        // 'register_status' => '1',
        // 'company_id' => Company::where('name', 'affiliate')->get()->first()->id,
        // 'address' => 'Jl. Holis Regency No.37A, Babakan, Babakan Ciparay',
        // 'password' => Hash::make('admin1234'),
        // 'created_at' => now(),
        // ]);
        $superUser = User::create([
            'name' => 'super Admin',
            'email' => 'admin@admin.com',
            'role' => '1',
            'phone' => '08123456789',
            'register_status' => '1',
            // 'company_id' => Company::where('name', 'affiliate')->get()->first()->id,
            'address' => 'Jl. Holis Regency No.37A, Babakan, Babakan Ciparay',
            'password' => Hash::make('admin1234'),
            'created_at' => now(),
        ]);
        $superUser->assignRole('super-admin');
        

    }
}
