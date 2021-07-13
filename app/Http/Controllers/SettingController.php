<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = filterData('\App\Models\Setting')->groupBy('product.id');
        $products = filterData('\App\Models\Product');
        if (!auth()->user()->hasRole('super-admin')) {
            $setting = Setting::where('company_id',getCompanyId())->get()->groupBy('product_id');
            $products = Product::where('company_id',getCompanyId())->get();
        }
        return view('admin.settingAdmin', ['settings' => $settings, 'products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        // return view('admin.editSettingAdmin', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $keys =[];
        $keys =array_keys($request->all());
        unset($keys[0],$keys[1]);
        foreach($keys as $key){
            $setting = Setting::where('product_id',$id)
            ->where('key',str_replace('_',' ',$key))->first();
            $setting->value = $request->$key;
            $setting->save();
        }
        $this->validate($request, [
            'persentage' => 'required',
            'value' => 'required',
            'label' => 'required',
            'product_id' => 'required'
        ]);

        Setting::where('id', $setting->id)->update([
            'key' => $request->key,
            'label' => $request->label,
            'value' => $request->value,
            'product_id' => $request->product_id
        ]);

        addToLog('Merubah settingan Id '. $setting->id);
        return redirect(route('admin.setting.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
