<?php

namespace App\Mail;

use App\Models\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailConfirmationCompany extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($company,$pass)
    {
        $this->companyId =$company;
        $this->pass =$pass;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data= Company::find($this->companyId);
        return $this->view('auth.emailConfirmation', ["user" => $data, "pass" => $this->pass]);
    }
}
