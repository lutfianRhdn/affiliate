<?php

namespace App\Http\Controllers\Reseller;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
        Cookie::queue('reseller', auth()->user()->id);
        if (!auth()->user()->hasRole('super-admin-company') || auth()->user()->hasRole('admin')) {
            Cookie::queue(Cookie::forget('reseller'));
            $user = User::find(Cookie::get('reseller'));
            Auth::logout($user);
            Auth::login($user);
            return redirect()->route('admin');
        }else{
            $user = User::find($request->user_id);
            Auth::logout($user);
            Auth::login($user);
        }
   
        return redirect()->route('reseller');
    }
}
