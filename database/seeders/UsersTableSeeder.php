<?php
namespace Database\Seeders;

use App\Models\Company;
use App\Models\Product;
use App\Models\Role;
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
        // Super admin affiliate
        $user = User::create([
            'name' => 'Admin Affiliate',
            'email' => 'admin@affiliate.com',
            'role' => '2',
            'phone' => '08123456789',
            'register_status' => '1',
            'company_id' => Company::where('name', 'Affiliate')->get()->first()->id,
            'address' => 'Jl. Holis Regency No.37A, Babakan, Babakan Ciparay',
            'password' => Hash::make('admin1234'),
            'created_at' => now(),
        ]);
        $admin = Role::create(['name'=>'super-admin-affiliate','company_id'=>Company::where('name','affiliate')->first()->id]);
        $permissionForSuperAdminCompany =  Role::where('name','super-admin')->get()->first();
        $permissions =$permissionForSuperAdminCompany->permissions()->whereNotIn('name',['company.view','company.edit','company.create','company.delete'])->get();
        $admin->syncPermissions($permissions);
        Role::create(['name'=>'reseller-affiliate','company_id'=>Company::where('name','affiliate')->first()->id]);
        $user->assignRole('super-admin-company','super-admin-affiliate');

        
        // superAdmin
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
