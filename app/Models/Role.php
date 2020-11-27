<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends \Spatie\Permission\Models\Role
{
    use HasFactory;

    protected $fillable = ['', 'name', 'slug','guard_name'];
    protected $guard= '*';

    public function User(){
        return $this->belongsToMany('App\Models\User','role_id');   
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
