<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('permission:product.view')->only('index');
        $this->middleware('permission:product.create')->only('store');
        $this->middleware('permission:product.edit')->only('update');
        $this->middleware('permission:product.delete')->only('destroy');
    }

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
        
        $productModel = new Product;
        $productModel->createProduct($request);
        
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
            'regex' => ['required'],
        ]);

        $productModel = new Product;
        $productModel->updateProduct($request, $product->id);
        
        LogActivity::addToLog("Edit product id ".$product->id);
        return redirect(route('admin.product.index'))->with('status', 'Data updated successfully');
    }

    public function updateCode(Request $request, Product $product) {
        $productModel = new Product;
        $productModel->updateCode($request, $product->id);

        return
        redirect(route('admin.product.index'))->with('status', 'Code updated successfully');
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
