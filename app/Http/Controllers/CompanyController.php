<?php

namespace App\Http\Controllers;

use App\Mail\EmailApproval;
use App\Mail\EmailApprovalCompany;
use App\Mail\EmailConfirmation;
use App\Mail\EmailConfirmationCompany;
use Illuminate\Support\Facades\Mail;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Cookie;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:company.view')->only('index');
        $this->middleware('permission:company.create')->only('create');
        $this->middleware('permission:company.edit')->only('update');
        $this->middleware('permission:company.delete')->only('destroy');
    }
    public function index()
    {
        $companies= Company::all();
        $users = User::whereHas('roles',function($role){
            $role->where('name','super-admin-company');
        })->where('users.company_id','!=',null)->get()->groupBy('company_id');
        $adminCompany =[];
        foreach ($users as $user ) {
            array_push($adminCompany,$user->first());
        }
        return view('admin.companyAdmin',compact('adminCompany'));
    
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
        $request->validate([
            'name'=>'required',
            'email'=> 'required|unique:users',
            'company'=>'required|unique:companies,name',
            'phone'=>'required|min:8|max:12'
        ]);

        $request->request->add(['password'=> Str::random(8)]);
        $company = new Company;
        $data = $company->addCompany($request->all());   
        Mail::to($data->email)->send(new EmailConfirmation($data->id, $request->password));
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        $companyModel = new Company;
        $companyModel->editCompany($company,$request);
            return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $users = User::with('company')->where('company_id',$company->id)->get();
        // $users->first()->delete();
        foreach ($users as $user ) {
            if ($user->hasRole('admin')) {
                $company->delete();
                $user->delete();
            }
        }
        return redirect()->back();
    }
    // custom method
    public function approve(Request $request)
    {
        $company = User::find($request->id);
        $company->approve=1;
        $company->save();
        Mail::to($company->email)->send(new EmailApprovalCompany($company->id));
        return true; 
    }
    public function switchAccount(Request $request)
    {
        $user = User::find($request->user_id);
        Cookie::queue(Cookie::make('user',auth()->user()->id));
        if (!auth()->user()->hasRole('super-admin')) {
            Cookie::queue(Cookie::forget('user'));
        }
        // Auth::logout($user);
        Auth::login($user);
        return redirect()->route('admin');
    }
}
