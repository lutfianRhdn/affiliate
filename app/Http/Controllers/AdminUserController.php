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
}
