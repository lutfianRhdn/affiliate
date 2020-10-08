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
            ->join('products', 'users.product_id', '=', 'products.id')
            ->select('users.*', 'products.product_name')
            ->where('users.role', 2)
            ->get();
        $product = Product::all();
        return view('admin.user', ['users' => $users, "products" => $product]);
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
            'phone' => ['required', 'min:9', 'max:14'],
            'product_id' => ['required']
            ]);
            // dd($request->all());
        
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'product_id' => $request->product_id,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'ref-code' => DB::getTablePrefix() . Str::random(6)
        ]);
        $role = $request->role == '1' ? ' Admin' : 'Reseller';
        Mail::to($user['email'])->send(new KonfirmasiEmail($user));
        LogActivity::addToLog("Menambahkan ".$role." ".$request->email);
        return redirect("/admin/user")->with('status', 'Data berhasil ditambahkan');
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
            'product_id' => ['required'],
            'role' => ['required'],
        ]);

        User::where('id', $user->id)
            ->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'product_id' => $request->product_id,
                'role' => $request->role,
            ]);
        $role = $request->role == '1' ? ' Admin' : 'Reseller';
        LogActivity::addToLog("Mengubah data " . $role . " " . $request->email);
        return redirect("/admin/user")->with('status', 'Berhasil update data '.$request->name);
    }

    public function destroy(User $user)
    {
        User::destroy($user->id);
        LogActivity::addToLog("Menghapus akun".$user->email);
        return redirect("/admin/user")->with('status', 'Data berhasil dihapus');
    }
}
