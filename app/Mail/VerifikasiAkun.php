<?php

namespace App\Mail;

use Crypt;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifikasiAkun extends Mailable
{
    use Queueable, SerializesModels;

    private $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
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
         $encryptedEmail = Crypt::encrypt($this->user->email);

         $link = route('signup.verify', ['token' => $encryptedEmail]);
 
         return $this->subject('Verify Your Email Address')
             ->with('link', $link)
             ->view('email.verifikasi');

    }
}
