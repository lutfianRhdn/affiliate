<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['', 'product_name', 'description','regex','permission_ip','url','company_id'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function setting()
    {
        return $this->hasMany(Setting::class);
    }
public function clients()
{
    return $this->hasMany(Client::class);
}
public function commissions()
{
    return $this->hasMany(Commission::class);
}

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

    public function createProduct(array $data) {
        if (!array_key_exists('company',$data)) {
            $data['company']= null;
        }
        $comId= getCompanyId($data['company']);
        $product = Product::create([
            'product_name' => $data['product_name'],
            'description' => $data['description'],
            'regex' => $data['regex'],
            'url' => $data['urlProduct'],
            'permission_ip' => $data['permissionUrl'],
            'company_id'=>$comId
        ]);
            Setting::create([
                'key'=>'percentage',
                'label'=>'percentage',
                'value'=>10,
                'product_id'=>$product->id,
                'company_id'=> $comId,
                'group'=>'admin'
            ]);
            Setting::create([
                'key'=>'day of settelment',
                'label'=>'Day of Settelment',
                'value'=>10,
                'product_id'=>$product->id,
                'company_id'=> $comId,
                'group'=>'admin'
            ]);
        $id = Hashids::encode($product->id);
        $product->code = view('pages.register_embed', compact('id'))->render(); 
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
