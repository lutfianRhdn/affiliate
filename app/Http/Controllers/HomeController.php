<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Commission;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (auth()->user()->hasRole('reseller')) {
            return $this->resellerCommission();
        }else{
            return view('dashboard');
        }

        // dd($data);
        
    }
    public function markReadNotify(Request $request)
    {
        auth()->user()->unreadNotifications->where('id', $request->id)->markAsRead();
        if ($request->id ==null) {
            foreach (auth()->user()->unreadNotifications as $notification ) {
                $notification->markAsRead();
            }
        }
        return response(['status'=>'success'],200);
    }
    private function calculateCommission($data)
    {
        $total =0;
        foreach ($data as $commission) {
            $total += $commission->total_commission;
        }
        return $total;
    }
    private function resellerCommission()
    {
        $commissions =Commission::where('user_id',auth()->user()->id)->get();
        $totalClient = Client::where('user_id',auth()->user()->id)->get()->count();
        $totalCommission= $this->calculateCommission($commissions);
        $remainingCommission =$this->calculateCommission($commissions->where('status',false));
        $transferedCommission =$this->calculateCommission($commissions->where('status',true));
        $lastCommission = Commission::latest()->where('user_id',auth()->user()->id)->first();
        $now = Carbon::now();
        $clients = Client::whereMonth('created_at',$now->format('m'))->where('user_id',auth()->user()->id)->limit(5)->get();
        // dd($clients);
        $data =[];
        
        foreach ($this->months as $month ) {
            $commission = Commission::whereMonth('created_at',Carbon::parse($month)
            ->format('m'))->whereYear('created_at',$now->format('Y'))
            ->where('user_id',auth()->user()->id)
            ->first();
            
            $data += [$month=>$commission !== null ?$commission->total_commission : 0];
        }
        $data= json_encode($data);
        $months= $this->months;
        return view('admin.dashboard',compact(
            'totalClient','clients',
            'totalCommission','data',
            'remainingCommission','transferedCommission',
            'lastCommission','months'));
    }
    public function filterByMonth(Request $request)
    {
        $now = Carbon::now();
        $month = Carbon::parse($request->month)->format('m');
        $commissions =Commission::whereMonth('created_at',$month)->whereYear('created_at',$now->format('Y'))->where('user_id',auth()->user()->id)->get();
        $totalClient = Client::whereMonth('created_at',$month)->whereYear('created_at',$now->format('Y'))->where('user_id',auth()->user()->id)->get()->count();
        $totalCommission= $this->calculateCommission($commissions);
        $remainingCommission =$this->calculateCommission($commissions->where('status',false));
        $transferedCommission =$this->calculateCommission($commissions->where('status',true));
        $clientsData = Client::whereMonth('created_at',$month)->whereYear('created_at',$now->format('Y'))->where('user_id',auth()->user()->id)->limit(5)->get();
        $clients = [];
        foreach ($clientsData as $client ) {
            array_push($clients,[
                'name'=>$client->name,
                'company'=>$client->company
                ]);
        }
        // dd($clients);
        return response([
            'month'=>$request->month,
            'data'=>[
                'total_client'=>$totalClient,
                'total_commission'=>$totalCommission,
                'total_transfered'=>$transferedCommission,
                'total_remaining'=>$remainingCommission,
                'clients'=>$clients
            ]
        ],200);
    }
}
