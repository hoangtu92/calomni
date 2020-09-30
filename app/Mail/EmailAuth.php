<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailAuth extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $auth;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $auth)
    {
        //
        $this->user = $user;
        $this->auth = $auth;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Auth key")
            ->to($this->user->email)
        ->markdown('emails.auth-key');
    }
}
