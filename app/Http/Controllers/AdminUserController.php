<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use App\Mail\KonfirmasiEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AdminUserController extends Controller
{
    public function index(User $model)
    {
        return view('admin.user', ['users' => $model->paginate(15)]);
    }

    public function create() {
        return view("admin.addUser");
    }

    public function store(Request $request) {
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'password' => Hash::make($request['password']),
            'role' => $request['role'],
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
        return view('admin.edituser', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        User::where('id', $user->id)
            ->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'role' => $request->role
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
