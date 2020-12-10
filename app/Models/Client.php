<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $guarded =['id'];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function createClient(array $data)
    {
        return Client::create($data);
    }
}
