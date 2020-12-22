<?php

namespace App\Http\Controllers\Reseller;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class ResellerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('users.dashboard', ['auth' => $this->middleware('auth')]);
    }
    public function switchAccount(Request $request)
    {
        $user = User::find($request->user_id);
        Cookie::queue(Cookie::make('reseller',auth()->user()->id));

        if (!auth()->user()->hasRole('super-admin-company') || auth()->user()->hasRole('admin')) {
            Cookie::queue(Cookie::forget('reseller'));
        }

        // dd(auth()->user()->hasRole('super-admin-company')); 
        Auth::logout($user);
        Auth::login($user);
        if (!auth()->user()->hasRole('super-admin-company') || auth()->user()->hasRole('admin')) {
            return redirect()->route('admin');
        }
        return redirect()->route('reseller');
    }
}
