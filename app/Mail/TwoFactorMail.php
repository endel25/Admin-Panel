<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class TwoFactorMail extends Mailable
{
    public $code;

    public function __construct($code)
    {
        $this->code = $code;
    }

    public function build()
    {
        return $this->subject('Your Two-Factor Code')
                    ->view('emails.two-factor');
    }
}
