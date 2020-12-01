<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends \Spatie\Permission\Models\Role
{
    use HasFactory;

    protected $fillable = ['', 'name', 'slug','guard_name','company_id'];
    protected $guard= '*';

    public function User(){
        return $this->belongsToMany('App\Models\User','role_id');   
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    // custom
    public function createRole(array $data)
    {
        if (!array_key_exists('company',$data)) {
            $data['company'] =null;
        }
        $comId= getCompanyId($data['company']);
        $company = Company::find($comId);
        $role = Role::create(['name' => $data['name'].'-'.$company->name,'company_id'=>$comId]);
        return $role;
    }
}
