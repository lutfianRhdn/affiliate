<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

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

    public function getUrl($id)
    {
        $url = Product::select('products.url')->where('products.id', $id)->first();
        return $url;
    }

    public function createProduct($request) {
        $product = Product::create([
            'product_name' => $request->product_name,
            'description' => $request->description,
            'regex' => $request->regex,
            'url' => $request->urlProduct,
            'permission_ip' => $request->permissionUrl ,
            'code' => $request->code
            ]);
        $id = Hashids::encode($product->id);
        // crypt()
        $product->code = view('pages.RegisterEmbed', compact('id'))->render(); 
        $product->save();
        return $product;
    }

    public function updateProduct($request, $id) {
        $product = Product::where('id', $id)->update([
            'product_name' => $request->product_name,
            'description' => $request->description,
            'regex' => $request->regex,
            'url' => $request->urlProduct,
            'permission_ip'=> $request->permissionUrl
            // 'code' => $request->code
        ]);

        return $product;
    }

    public function updateCode($request, $id) {
        $code = Product::where('id', $id)->update(['code'=>$request->code]);
        return $code;
    }

}
