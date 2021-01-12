<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        
        return view('admin.dashboard');
    }
    public function markReadNotify(Request $request)
    {
        auth()->user()->unreadNotifications->where('id', $request->id)->markAsRead();
        if ($request->id ==null) {
            foreach (auth()->user()->unreadNotifications as $notification ) {
                $notification->markAsRead();
            }
        }
        return response(['status'=>'success'],200);
    }
}
