<?php

namespace App\Mail;

use App\Models\Copy;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeMail extends Mailable
{

    use Queueable, SerializesModels;
    private $user;

    /**
     * AlertStarted constructor.
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
            'user'     => $this->user
        ];

        return $this->with($params)->view('mails.welcome')->subject($params['subject']);
    }
}