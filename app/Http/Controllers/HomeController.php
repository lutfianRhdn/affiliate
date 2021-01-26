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
    protected $where,$value;
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
            $where= 'user_id';
            $value= auth()->user()->id;
            return $this->DashboardCommission('user_id',auth()->user()->id);
        }else{
            $where= 'company_id';
            $value= auth()->user()->company !== null ? auth()->user()->company->id:null;
            return $this->DashboardCommission('company_id',auth()->user()->company_id);
            // return view('dashboard');
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
    private function calculateRevenue($data =null,$where,$value,$collumn ='total_commission'){
        $result =[];
        $now = Carbon::now();
        foreach ($this->months as $month ) {
            $commissions = Commission::whereMonth('created_at',Carbon::parse($month)
            ->format('m'))
            ->where($where,$value);
            // dd($commission->get());
            $totalCommission =0;
            if ($data !== null) {
                $commissions=$commissions->where('status',$data);
            }
            foreach ($commissions->get() as $commission ) {
                
                $totalCommission += $commission->$collumn;
            }
            $result += [$month=>$totalCommission];
        }
        return $result;
    }
    private function DashboardCommission($where, $value)
    {
        $commissions =Commission::where($where,$value)->get();
        $totalClient = Client::where($where,$value)->get()->count();
        $totalCommission= $this->calculateCommission($commissions);
        $remainingCommission =$this->calculateCommission($commissions->where('status',false));
        $transferedCommission =$this->calculateCommission($commissions->where('status',true));
        $lastCommission = Commission::latest()->where($where,$value)->first();
        $now = Carbon::now();
        $clients = Client::whereMonth('created_at',$now->format('m'))->where($where,$value)->limit(5)->get();
        $data =[];
        $revenue =$this->calculateRevenue(null,$where,$value);
        $remaining =$this->calculateRevenue(false,$where,$value);
        $transfered =$this->calculateRevenue(true,$where,$value);
        $data = ['revenue'=>$revenue,'remaining'=>$remaining,'transfered'=>$transfered];
        // dd($lastCommission);
        if (!auth()->user()->hasRole('reseller')) {
            $data['revenue']= $this->calculateRevenue(null,$where,$value,'total_payment');
            $data['reseller']= $this->calculateRevenue(null,$where,$value);
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
        $commissions =Commission::whereMonth('created_at',$month)->where('company_id',auth()->user()->company_id)->get();
        $totalClient = Client::whereMonth('created_at',$month)->where('company_id',auth()->user()->company_id)->get()->count();
        $totalCommission= $this->calculateCommission($commissions);
        $remainingCommission =$this->calculateCommission($commissions->where('status',false));
        $transferedCommission =$this->calculateCommission($commissions->where('status',true));
        $clientsData = Client::whereMonth('created_at',$month)->where('company_id',auth()->user()->company_id)->limit(5)->get();
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
