<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['', 'product_name', 'description','regex'];

    public function getData()
    {
        $product = Product::all();
        return $product;
    }

    public function getRegex($id)
    {
        $regex = Product::select('products.regex')->where('products.id', $id)->first();
        return $regex;
    }
}
