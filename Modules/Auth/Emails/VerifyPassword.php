<?php

namespace Modules\Auth\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class VerifyPassword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Code verify.
     *
     * @var String
     */
    protected $code;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($code)
    {
        $this->code = $code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('auth::emails.VerifyForgotPassword')->with([
            'code' => $this->code,
         ]);
    }
}
