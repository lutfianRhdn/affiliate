<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use App\Mail\KonfirmasiEmail;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = DB::table('users')
            ->where('role', 1)
            ->paginate(5);
        return view('admin.user', ['users' => $users]);
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
            'password' => ['required', 'string', 'min:8', 'confirmed',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/'],
            'password_confirmation' => ['required_with:password','same:password'],
            'phone' => ['required', 'min:9', 'max:14'],
            'product_id' => ['required'],
            'country' => ['required'],
            'state' => ['required'],
            'city' => ['required'],
            'address' => ['required']
        ]);

            $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $random = substr(str_shuffle($permitted_chars), 0, 6);
            $model_user = new User;
            $product = new Product;
            $regex = $product->getRegex($request->product_id);
            do{
                $ref_code = $regex->regex.$random;
                $check = $model_user->getRefCode($ref_code);
            }while($check != null);
    
            if($check == null){
                $user = $model_user->createUser($request->all(), $ref_code);
            }
        // Mail::to($user['email'])->send(new KonfirmasiEmail($user));
        LogActivity::addToLog("Menambahkan ".$role." ".$request->email);
        return redirect("/admin/user")->with('status', 'Admin successfully added');
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
        // dd($request->all());
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
        LogActivity::addToLog("Mengubah data " . $role . " " . $request->email);
        return redirect("/admin/user")->with('status', 'Berhasil update data '.$request->name);
    }

    public function destroy(User $user)
    {
        if($user->email != 'admin@admin.com'){
            User::destroy($user->id);
            LogActivity::addToLog("Delete account " . $user->email);
            return redirect("/admin/user")->with('status', 'Data deleted successfully');
        }
        return redirect("/admin/user")->with('statusAdmin', 'Admin cannot be deleted');
    }
}
