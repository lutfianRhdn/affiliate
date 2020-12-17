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
        ->get();
        // dd($clients);
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
        //
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
    public function update(Request $request, $id)
    {
        //
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
            // dd('can');
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
        
        // dd($transactions);
        return view('reseller.transaction',compact('transactions'));
    }
}
