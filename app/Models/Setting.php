<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $fillable = ['', 'key','label','value', 'product_id','group','company_id'];
    public function company()
    {
        return $this->belongsToMany(Company::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
