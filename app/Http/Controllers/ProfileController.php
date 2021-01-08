<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;
use App\Mail\EmailConfirmation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Vinkla\Hashids\Facades\Hashids;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        return view('profile.edit');
    }

    /**
     * Update the profile
     *
     * @param  \App\Http\Requests\ProfileRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileRequest $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required|email',
            'phone'=>'required|numeric',
            'address'=>'required',
            'bank_type'=>'required',
            'account_number'=>'required|numeric',
        ]); 
        $user = auth()->user();
        $requestAll = $request->except('email');
        $user->update($requestAll);
        
        if ($user->profile !== null) {
            $user->profile()->update(['bank_type'=>$request->bank_type,'account_number'=>$request->account_number]);
        }else{
            $user->profile()->create(['bank_type'=>$request->bank_type,'account_number'=>$request->account_number]);
        }
        if ($user->email == $request->email) {
            return back()->withStatus(__('Profile successfully updated.'));
        }
        Mail::to($request->email)->send(new EmailConfirmation($user->id, $user->pass,$request->email));
        return back()->withStatus(__('Profile successfully updated,Please Check Email To Confirm Update Email'));

    }

    /**
     * Change the password
     *
     * @param  \App\Http\Requests\PasswordRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password(PasswordRequest $request)
    {
        auth()->user()->update(['password' => Hash::make($request->get('password'))]);

        return back()->withStatusPassword(__('Password successfully updated.'));
    }
    public function EmailConfirmation($id,$email)
    {
        // dd($email);
        $user = User::find(Hashids::decode($id))->first();
        $user->email = $email;
        $user->save();
        return redirect(url('/thankyou.php?st=0&res=Confirmation Success'));
    }
}
