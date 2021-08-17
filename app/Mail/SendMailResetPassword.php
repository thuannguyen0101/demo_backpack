<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMailResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $link;

    /**
     * SendMailResetPassword constructor.
     * @param $token
     */
    public function __construct($token)
    {
        $this->link = env('APP_URL') . '/reset-password?token=' . $token;
        $this->subject("PremiumSupportアプリ パスワード再発行のお知らせ");
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.reset-password');
    }
}
