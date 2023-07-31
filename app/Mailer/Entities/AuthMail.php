<?php

namespace App\Mailer\Entities;

use Illuminate\Mail\Mailable;
use App\Mailer\Exceptions\MailExeption;
use Illuminate\Support\Facades\View;
use App\Mailer\Entities\Mail;

final class AuthMail extends Mail implements MailInterface
{
    protected $dataValidation = [
        'username', 'email', 'link'
    ];
    
    public function __construct(string $subject, array $data)
    {
        $this->view = "registration";
        $this->subject = $subject;

        parent::__construct($data);
    }
}
