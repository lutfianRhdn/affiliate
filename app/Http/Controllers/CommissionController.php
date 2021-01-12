<?php

namespace App\Http\Controllers;

use App\Exports\CommissionExport;
use App\Models\Commission;
use App\Models\Role;
use App\Models\User;
use App\Notifications\CompletedPaymentInvoiceNotification;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class CommissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

    public function index()
    {
        $commissions = filterData('App\Models\Commission');
        // dd($commissions);
        $totalCommission = $this->calculateCommission($commissions);
        $remainingCommission =$this->calculateCommission($commissions->where('status',false));
        $transferedCommission =$this->calculateCommission($commissions->where('status',true));
        $users = filterData('\App\Models\User');
        $resellers = [];
        foreach ($users as $user) {
            if ($user->hasRole('reseller')) {
                array_push($resellers,$user);
            }
        }
        $months = $this->months;

        return view('admin.commission',compact('commissions','totalCommission','remainingCommission','transferedCommission','resellers','months'));
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
        // dd($request->file('image'));
        $request->validate([
            'image'=>'required|mimes:jpeg,png,jpg|max:1999'
        ]);
        $filenameWithExt = $request->file('image')->getClientOriginalName();
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $extension = $request->file('image')->getClientOriginalExtension();
        $filename = $filename.'_'.time().'.'.$extension;
         $request->file('image')->storeAs('public/evidence', $filename);
        $commission->photo_path = $filename;
        $commission->status = 1;
        $commission->save();
        $commission->user->notify(new CompletedPaymentInvoiceNotification($commission,auth()->user()->name));
        // dd($path);
        return redirect()->back();
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
    public function export()
    {
        return  Excel::download(new CommissionExport(),'commission.csv');
    }
    public function filter(Request $request)
    {
        $commissions = filterData('App\Models\Commission');
        if ($request->month !== 'null') {
            $commissionsFiltered =[];
            foreach ($commissions as $commission) {
                if ($commission->created_at->format('F')== $request->month) {
                    array_push($commissionsFiltered,$commission);
                }
            }
            $commissions = collect($commissionsFiltered);
        }
        if ($request->reseller !== 'null') {
            $commissions = $commissions->where('user.name',$request->reseller);
        }
        if ($request->status !== 'null') {
            $commissions = $commissions->where('status',$request->status=='paid'? true:false); 
            
        }
        // dd($commissions);
        
        $totalCommission = $this->calculateCommission($commissions);
        $remainingCommission =$this->calculateCommission($commissions->where('status',false));
        $transferedCommission =$this->calculateCommission($commissions->where('status',true));
        return response(['total_commission'=>$totalCommission,'remaining_commission'=>$remainingCommission,'transfered_commission'=>$transferedCommission],200);
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
