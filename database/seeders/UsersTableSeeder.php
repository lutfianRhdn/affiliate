<?php
namespace Database\Seeders;

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
        DB::table('users')->insert([
        'name' => 'Admin Affiliate',
        'email' => 'admin@affiliate.com',
        'role' => '1',
        'phone' => '08123456789',
        'register_status' => '1',
        'country' => 'Indonesia',
        'state' => '32',
        'region' => '3204',
        'address' => 'Jl. Holis Regency No.37A, Babakan, Babakan Ciparay',
        'password' => Hash::make('admin1234'),
        'created_at' => now(),

        ]);
    }
}
