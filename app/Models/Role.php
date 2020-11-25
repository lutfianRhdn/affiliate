<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $fillable = ['', 'name', 'slug','guard_name'];
    
    public function User(){
        return $this->belongsToMany('App\Models\User','role_id');   
    }
    public function company()
    {
        return $this->belongsToMany(Company::class);
    }
}
