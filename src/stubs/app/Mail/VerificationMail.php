<?php

namespace App\Mail;

use App\Models\Copy;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    private $user;

    /**
     * AlertStarted constructor.
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
            'subject' => Copy::server('USER_VERIFICATION_MAIL_SUBJECT', env('APP_NAME')),
            'title'   => Copy::server('USER_VERIFICATION_MAIL_TITLE', $this->user->name ?? ''),
            'content' => Copy::server('USER_VERIFICATION_MAIL_CONTENT'),
            'link'    => Copy::server('USER_VERIFICATION_MAIL_LINK'),
            'url'     => route('mail.verify', ['token' => $this->user->mail_token]),
        ];

        return $this->with($params)->view('mails.verification-mail')->subject($params['subject']);
    }
}
