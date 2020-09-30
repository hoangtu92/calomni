<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class EmailVerification extends Mailable
{
    use Queueable, SerializesModels;
    public $verifyUrl;
    protected $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($verifyUrl, $user)
    {
        //
        $this->user = $user;
        $this->verifyUrl = $verifyUrl;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = "Request Host Email verification";
        $view = 'emails.rh-verify-email';

        $user = User::find($this->user->id);
        Log::info($user);
        if($user->role == User::SH){
            $subject = "Service Host Email verification";
            $view = 'emails.sh-verify-email';
        }
        return $this->subject($subject)
            ->to($this->user->email, $this->user->name)
            ->from("ml.codesign3@gmail.com", "Verification")
            ->markdown($view);
    }
}
