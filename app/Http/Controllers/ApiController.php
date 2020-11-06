<?php

namespace App\Http\Controllers;

use App\Http\Resources\CityResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProvinceResource;
use App\Models\City;
use App\Models\Product;
use App\Models\Province;
use Illuminate\Http\Request;

class ApiController extends Controller
{

    public function ProductApi()
    {
        $products = Product::get();
        return (ProductResource::collection($products));
    }
    public function ProvinceApi()
    {
        $provinces = Province::get();
        return (ProvinceResource::collection($provinces));
    }
   
    public function CityApi(Request $request)
    {
        $provinces = City::where('province_id',$request->province)->get();
        return ['results' =>(CityResource::collection($provinces))];
    }


}
