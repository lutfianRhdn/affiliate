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

class AdminResellerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = DB::table('users')
                    ->join('products', 'users.product_id', '=', 'products.id')
                    ->select('users.*', 'products.product_name', 'products.regex')
                    ->where('users.role', 2)
                    ->get();
        $products = Product::all();
        return view('admin.resellerAdmin', ['users' => $users, 'products' => $products]);
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
        $this->validate($request, [
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

        $regex = DB::table('products')->select('products.regex')->where('products.id', $request->product_id)->get();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'product_id' => $request->product_id,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'ref-code' => $regex[0]->regex
        ]);
        $role = $request->role == '1' ? ' Admin' : 'Reseller';
        Mail::to($user['email'])->send(new KonfirmasiEmail($user));
        LogActivity::addToLog("Menambahkan ".$role." ".$request->email);
        return redirect("/admin/reseller")->with('status', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'min:9', 'max:14'],
            'product_id' => ['required'],
            'role' => ['required'],
        ]);

        User::where('id', $request->id)
            ->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'product_id' => $request->product_id,
                'role' => $request->role,
            ]);
        $role = $request->role == '1' ? ' Admin' : 'Reseller';
        LogActivity::addToLog("Mengubah data " . $role . " " . $request->email);
        return redirect("/admin/reseller")->with('status', 'Berhasil update data ' . $request->name);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    
    public function destroy(Request $request)
    {
        User::destroy($request->id);
        LogActivity::addToLog("Menghapus akun" . $request->email);
        return redirect("/admin/reseller")->with('status', 'Data berhasil dihapus');
    }
}
