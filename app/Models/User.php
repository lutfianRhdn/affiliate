<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'ref_code',
        'role',
        'product_id',
        'register_status',
        'country',
        'state',
        'region',
        'address',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [ 
        'password',
        'remember_token',
        'ref_code',
        
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getDataEmail($id)
    {
        $data = User::select('users.name as name', 'users.email as email', 'users.phone as phone', 'users.address as address', 'users.ref_code as ref_code',
            'products.product_name','cities.city_name_full as city_name_full', 'provinces.province_name as province_name')
            ->where('users.id', $id)
            ->join('products','products.id','=','users.product_id')
            ->join('cities','cities.id','=','users.region')
            ->join('provinces','provinces.id','=','users.state')->first();

        return $data;
    }
}
