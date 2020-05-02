<?php

namespace App\Mail;

use Crypt;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LupaSandi extends Mailable
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
        $url = new \stdClass;
        $url->token = $this->user->email;
        $url->expired = Carbon::now()->add(1, 'day')->timestamp;
        $url = Crypt::encrypt($url);

        $link = route('reset_pass.go', $url);

        return $this->subject('Lupa Kata Sandi')
            ->with('link', $link)
            ->view('email.reset_pass');
    }
}
