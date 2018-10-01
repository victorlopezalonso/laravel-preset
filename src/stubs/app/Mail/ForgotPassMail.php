<?php

namespace App\Mail;

use App\Models\Copy;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPassMail extends Mailable
{
    use Queueable, SerializesModels;

    private $user;

    /**
     * ForgotPassMail constructor.
     *
     * @param $user
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
        $params = [
            'subject' => Copy::server('WELCOME_MAIL_SUBJECT'),
            'title'   => Copy::server('WELCOME_MAIL_TITLE'),
            'content' => Copy::server('WELCOME_MAIL_CONTENT'),
            'url'     => url('password/reset/'.$this->user->remember_token),
        ];

        return $this->with($params)->view('mails.forgotpassword')->subject($params['subject']);
    }
}
