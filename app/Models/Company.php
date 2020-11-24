<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class Company extends Authenticatable
{
    use HasRoles,HasFactory;

    protected $guarded = [];
    protected $guard_name = 'web';

    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function settings()
    {
        return $this->hasMany(Setting::class);
    }

    // custom method
    public function addCompany( $data)
    {
        // dd($data);
        return Company::create([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'company_name'=>$data['company'],
            'phone'=>$data['phone'],
            'password'=> Hash::make($data['password']) ,
            'name'=>$data['name'],
            'is_active'=>0,
            'approve'=>0
        ]);
    }
}
