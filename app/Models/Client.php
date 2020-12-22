<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded =['id'];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function createClient(array $data)
    {
        return Client::create($data);
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
