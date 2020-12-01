<?php

namespace App\Http\Controllers;

use App\Mail\EmailApprovalCompany;
use App\Mail\EmailConfirmation;
use App\Mail\KonfirmasiEmail;
use App\Models\Company;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
class AdminUserController extends Controller
{

    
    public function __construct()
    {
        $this->middleware('permission:admin.view')->only('index');
        $this->middleware('permission:admin.create')->only('store');
        $this->middleware('permission:admin.edit')->only('update');
        $this->middleware('permission:admin.delete')->only('destroy');
    }


    public function index()
    {
        $users = User::whereNotIn('role',[1]);
        $userAdmin= [];
        $users= filterData($users);
        $companies= getAllCompanies();
        foreach($users as $user){
            if ($user->hasRole('admin')) {
                array_push($userAdmin,$user);
            }
        }
        $users =$userAdmin ;
        return view('admin.user', compact('users','companies'));
    }

    public function create() {
        $product = Product::all();
        return view("admin.addUser", ["products" => $product]);
    }

    public function store(Request $request) 
    {
        $this->validate($request,[
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'min:9', 'max:14'],
        ]);
            $userModel = new User;
            $request->request->add(['password'=>Str::random(8),'address'=>'indonesia']);
           $user = $userModel->CreateAdmin($request->all());
            Mail::to($user->email)->send(new EmailConfirmation($user->id,$request->password));
        // Mail::to($user['email'])->send(new KonfirmasiEmail($user));
        addToLog("Menambahkan Adminn".$request->email);
        return redirect(route('admin.user.index'))->with('status', 'Admin successfully added');
    }

    public function show(User $user)
    {
        //
    }

    public function edit(User $user) {
        $product = Product::all();
        return view('admin.edituser', ['user' => $user, 'products' => $product]);
    }

    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'min:9', 'max:14'],
            'role' => ['required'],
        ]);

        User::where('id', $user->id)
            ->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'role' => $request->role,
            ]);
        $role = $request->role == '1' ? ' Admin' : 'Reseller';
        addToLog("Mengubah data " . $role . " " . $request->email);
        return redirect(route('admin.user.index'))->with('status', 'Berhasil update data '.$request->name);
    }

    public function destroy(User $user)
    {
        if($user->email != 'admin@admin.com'){
            User::destroy($user->id);
            addToLog("Delete account " . $user->email);
            return redirect(route('admin.user.index'))->with('status', 'Data deleted successfully');
        }
        return redirect(route('admin.user.index'))->with('statusAdmin', 'Admin cannot be deleted');
    }
    // custom
    public function searchByCompany($company)
    {
        $companies = Company::where('name',$company)->get()->first();
        $users =[];
        foreach ($companies->users as $user) {
            if($user->hasRole('admin')){
                array_push($users,$user);
            }
        }
        $companies = getAllCompanies();
        return view('admin.user', compact('users','companies'));
    }
    public function approve(Request $request)
    {
        $company = User::find($request->id);
        $company->approve=1;
        $company->save();
        Mail::to($company->email)->send(new EmailApprovalCompany($company->id));
        return true; 
    }
}
