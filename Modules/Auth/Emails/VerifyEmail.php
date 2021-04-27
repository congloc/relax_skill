<?php

namespace Modules\Auth\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The User instance.
     *
     * @var User
     */
    protected $user;

    /**
     * Code verify.
     *
     * @var String
     */
    protected $code;

    protected $codeAuth;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$code, $codeAuth)
    {
        //
        $this->user = $user;
        $this->code = $code;
        $this->codeAuth = $codeAuth;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->markdown('auth::emails.VerifyEmail')->with([
        //     'code' => $this->code,
        // ]);
        return $this->markdown('auth::emails.VerifyEmail')->with([
            //     'code' => $this->code,
            'code' => $this->codeAuth,
         ]);
    }
}
