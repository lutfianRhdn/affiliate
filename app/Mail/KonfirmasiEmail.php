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

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $product = DB::table('users')
        ->join('products', 'users.product_id', '=', 'products.id')
        ->select('products.product_name','products.regex')
        ->where('users.id', $this->user->id)
        ->get();
        return $this->view('auth.emailTemplate', ["pp" => $this->user, "product" => $product]);
    }
}
