<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::where('user_id',auth()->user()->id)
        ->where('product_id',auth()->user()->product->id)
        ->orderBy('id','desc')
        ->get();
        return view('reseller.clients',compact('clients'));
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
        $client = new Client;
        $request->request->add(['user_id'=>auth()->user()->id,'product_id'=>auth()->user()->product->id]);
        $client->createClient($request->all());
        return redirect()->back()->with(['success'=>'Create Client Successfuly']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        $client->update($request->all());
        return redirect()->back()->with(['success'=>'Success Update data '.$client->name]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
    //  $clients= [];   
        if ($client->transactions->count() ==0) {
            $client->delete();
        return redirect()->back()->with(['success'=>'delete client success']);
        }
            return redirect()->back()->with(['error'=>'this field have relasion cant delete']);
    }
    public function transaction()
    {
    
        $transactions=Transaction::whereHas('client',function($q){
            $q->where('user_id',auth()->user()->id)
            ->where('product_id',auth()->user()->product->id);
        })->get();
        
        return view('reseller.transaction',compact('transactions'));
    }
    public function searchByClient($client)
    {
        $transactions=Transaction::whereHas('client',function($q) use($client){
            $q
            ->where('user_id',auth()->user()->id)
            ->where('name',$client)
            ->where('product_id',auth()->user()->product->id);
        })->get();
        // dd($transactions);
        return view('reseller.transaction',compact('transactions'));
    }
}
