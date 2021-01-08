<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use Vinkla\Hashids\Facades\Hashids;

class EmailConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct($user, $pass,$email =null)
    {
        $this->user = $user;
        $this->pass = $pass;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   
        $user = new User;
        $data = User::find($this->user);
        $email = $data->email;
        $id = Hashids::encode($data->id);
        if ($this->email !== null) {
            
            $data->email= $this->email;
        }
        return $this->view('auth.emailConfirmation', ["user" => $data,'email'=>$email,'id'=>$id ,"pass" => $this->pass]);
    }
}
