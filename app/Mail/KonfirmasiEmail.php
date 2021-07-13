<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class KonfirmasiEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $user;

    public function __construct($user, $pass)
    {
        $this->user = $user;
        $this->pass = $pass;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   
        $data = User::select('users.name as name', 'users.email as email', 'users.phone as phone', 'users.address as address', 'users.ref_code as ref_code',
            'products.product_name','cities.city_name_full as city_name_full', 'provinces.province_name as province_name')
            ->where('users.id', $this->user)
            ->join('products','products.id','=','users.product_id')
            ->join('cities','cities.city_id','=','users.region')
            ->join('provinces','provinces.province_id','=','users.state')->get();

        return $this->view('auth.emailTemplate', ["user" => $data, "pass" => $this->pass]);
    }
}
