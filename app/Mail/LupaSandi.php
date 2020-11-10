<?php

namespace App\Mail;

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
        $data = new \stdClass;
        $data->email = $this->user->email;
        $data->expired = Carbon::now()->add(1, 'day')->timestamp;
        $data->token = \Str::random(40);
        $file = urlencode(base64_encode($data->email));
        \Storage::disk('reset_pass')->put($file, json_encode($data));

        $link = route('reset_pass.go', $data->token . config('app.reset_pass_glue') . $file);

        return $this->subject('Lupa Kata Sandi')
            ->with('link', $link)
            ->view('email.reset_pass')
            ->text("email.reset_pass_plain");
    }
}
