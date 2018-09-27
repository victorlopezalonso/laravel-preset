<?php

namespace App\Mail;

use App\Models\Copy;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{

    use Queueable, SerializesModels;
    private $email;
    private $message;

    /**
     * AlertStarted constructor.
     * @param $email
     * @param $message
     */
    public function __construct($email, $message)
    {
        $this->email = $email;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $params = [
            'subject'     => Copy::server('CONTACT_MAIL_SUBJECT'),
            'title'       => Copy::server('CONTACT_MAIL_TITLE'),
            'content'     => Copy::server('CONTACT_MAIL_CONTENT', $this->email),
            'userMessage' => $this->message,
        ];

        return $this->with($params)->view('mails.contact')->subject($params['subject']);
    }
}