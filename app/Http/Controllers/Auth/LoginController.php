<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout'); 
    }

    public function login(Request $request) {
        $fieldData = $request->all();
        // dd($fieldData);
        $user = User::where('email',$fieldData['email'])->get()->first();
        if($user->register_status == 0){
            return redirect()->route('login')->with('error','Your provided information wrong!   ');
        }
            if (auth()->attempt(array('email' => $fieldData['email'], 'password' => $fieldData['password'])))
            {
                // dd(auth()->user()->hasRole('admin'));
                if (auth()->user()->hasRole('admin') && auth()->user()->register_status == 1) {
                    addToLog("Login");
                    return redirect()->route('admin');
                } elseif (auth()->user()->hasRole('reseller') && auth()->user()->approve == 1 && auth()->user()->status == 1 && auth()->user()->register_status == 1) {
                    return redirect()->route('reseller');
                } else {
                    return redirect()->route('login')->with('error', 'Your provided information wrong!');
                } 
            }
            else
            {
                return redirect()->route('login')->with('error','Your provided information wrong!');
            }
    }
}
