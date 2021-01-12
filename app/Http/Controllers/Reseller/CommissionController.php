<?php

namespace App\Http\Controllers\Reseller;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Commission;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CommissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $commissions = Commission::where('user_id',auth()->user()->id)->get();
        $totalCommission = $this->calculateCommission($commissions);
        $remainingCommission =$this->calculateCommission($commissions->where('status',false));
        $transferedCommission =$this->calculateCommission($commissions->where('status',true));

        return view('reseller.commission.index',compact('commissions','totalCommission','remainingCommission','transferedCommission'));
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
     * @param  \App\Models\Commission  $commission
     * @return \Illuminate\Http\Response
     */
    public function show(Commission $commission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Commission  $commission
     * @return \Illuminate\Http\Response
     */
    public function edit(Commission $commission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Commission  $commission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Commission $commission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Commission  $commission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Commission $commission)
    {
        //
    }
    // custom
    public function getTransactionMonth(Request $request)
    {
        $clients = Client::where('user_id',$request->user_id)->get();
        $transactionClient = [];
        foreach ($clients as $client) {
            foreach ($client->transactions as $transaction) {
                if (Carbon::parse($transaction->payment_date)->format('m-Y') == $request->month.'-'.$request->year) {
                    array_push($transactionClient,['name'=>$client->name,'company'=>$client->company,'transaction'=>$transaction->total_payment]);
                }
            }
        }
        // dd($transactionClient);
        return($transactionClient);
    }

   public function calculateCommission($data)
   {
       $total =0;
    foreach ($data as $commission) {
        $total += $commission->total_commission;
    }
    return $total;
   }
}
