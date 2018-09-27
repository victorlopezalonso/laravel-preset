<?php

namespace App\Mail;

use App\Models\Copy;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminCredentials extends Mailable
{

    use Queueable, SerializesModels;
    private $user;
    private $password;

    /**
     * AlertStarted constructor.
     * @param $user
     * @param $password
     */
    public function __construct($user, $password)
    {
        $this->user     = $user;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $params = [
            'subject'  => Copy::server('WELCOME_MAIL_SUBJECT'),
            'title'    => Copy::server('WELCOME_MAIL_TITLE'),
            'content'  => Copy::server('WELCOME_MAIL_CONTENT'),
            'user'     => $this->user,
            'password' => $this->password
        ];

        return $this->with($params)->view('mails.admin-credentials')->subject($params['subject']);
    }
}