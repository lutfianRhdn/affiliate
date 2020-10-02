<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index(User $model)
    {
        return view('admin.user', ['users' => $model->paginate(15)]);
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
                'phone' => $request->phone
            ]);

        return redirect(route('admin.user'))->with('status', 'Berhasil update data '.$request->name);
    }

    public function destroy(User $user)
    {
        User::destroy($user->id);
        return redirect(route('admin.user'))->with('status', 'Data berhasil dihapus');
    }
}
