<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::all();
        return view('admin.product', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.addProduct');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $this->validate($request, [
            'product_name' => ['required'],
            'description' => ['required'],
            'regex' => ['required', 'unique:products'],
        ]);
        
        Product::create([
            'product_name' => $request->product_name,
            'description' => $request->description,
            'regex' => $request->regex . "-"
        ]);
        LogActivity::addToLog("Menambahkan product ".$request->product_name);
        return redirect(route('admin.product.index'))->with('status', 'Data inserted successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        // 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $this->validate($request, [
            'product_name' => 'required',
            'description' => 'required',
            'regex' => ['required', 'unique:products'],
        ]);

        Product::where('id', $product->id)->update([
            'product_name' => $request->product_name,
            'description' => $request->description,
            'regex' => $request->regex."-",
            ]);
        
        LogActivity::addToLog("Edit product id ".$product->id);
        return redirect(route('admin.product.index'))->with('status', 'Data updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        Product::destroy($product->id);
        LogActivity::addToLog("Delete product ".$product->product_name);
        return redirect(route('admin.product.index'))->with('status', 'Item deleted successfully');
    }
}
