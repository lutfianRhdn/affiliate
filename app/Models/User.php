<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

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
        'address',
        'approve',
        'approve_note',
        'status',
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
    
    public function authorizeRoles($roles)
    {
        if (is_array($roles)) {
            return $this->hasAnyRole($roles) || abort(401, 'This action is unauthorized.');
        }
        return $this->hasRole($roles) || abort(401, 'This action is unauthorized.');
    }

    public function hasAnyRole($roles)
    {
        return null !== $this->role()->whereIn('name', $roles)->first();
    }
    public function hasRole($role)
    {
        return null !== $this->role()->where('name', $role)->first();
    }
    
    public function role()
    {
        return $this->belongsTo('App\Models\Role','role');
    }

    public function getUser($id)
    {
        $user = User::find($id);
        return $user;
    }

    public function getRefCode($data)
    {
        $data = User::select('id')->where('ref_code', $data)->first();
        return $data;
    }

    public function createUser($data, $ref_code)
    {
        $phone = str_replace("-", "", $data['phone']);
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $phone,
            'product_id' => $data['product_id'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'ref_code' => $ref_code,
            'address' => $data['address'],
        ]);

        return $user;
    }

    public function createUserAdmin($data, $ref_code, $password)
    {
        $phone = str_replace("-", "", $data->phone);
        $user = User::create([
            'name' => $data->name,
            'email' => $data->email,
            'phone' => $phone,
            'product_id' => $data->product_id,
            'password' => Hash::make($password),
            'role' => $data->role,
            'ref_code' => $ref_code,
            'address' => $data->address,
        ]);

        return $user;
    }

    public function getDataEmail($id)
    {
        $data = User::select('users.name as name', 'users.email as email', 'users.phone as phone', 'users.address as address', 'users.ref_code as ref_code',
            'products.product_name',)
            ->where('users.id', $id)
            ->join('products','products.id','=','users.product_id')->first();

        return $data;
    }

    public function getDataEmailConfirmation($id)
    {
        $data = User::select('name','ref_code','approve','approve_note')
            ->where('users.id', $id)->first();

        return $data;
    }

    public function emailConfirmation($email)
    {
        $data = User::where(['email' => $email])
        ->update(['register_status' => '1']);
        return $data;
    }

    public function getResellerData()
    {
        $data = User::select('users.id', 'users.name', 'users.phone', 'users.register_status', 'users.status', 'users.ref_code', 'users.id', 'users.role', 'users.id', 'users.approve', 'users.approve_note', 
                'users.created_at', 'users.email', 'users.address','products.product_name', 'products.regex')
                ->join('products', 'products.id', '=', 'users.product_id')
                ->where('users.role', 2)
                ->orderBy('users.created_at', 'DESC')
                ->get();
        return $data;
    }

    public function getApproval($id)
    {
        $data = User::find($id);
        $result = $data->update(array('status' => 1, 'approve' => 1));
        return $result;
    }

    public function getEjectApproval($id, $approve_note)
    {
        $data = User::find($id);
        $result = $data->update(array('approve' => 0, 'approve_note' => $approve_note));
        return $result;
    }

    public function getStatus($id)
    {
        $data = User::find($id);
        $result = $data->status == 0 ? $data->update(array('status' => 1)) : $data->update(array('status' => 0));
        return $result;
    }

    public function getProductID($email) {
        $product = User::select('users.product_id')->where('users.email', $email)->first();
        return $product;
    }
}
