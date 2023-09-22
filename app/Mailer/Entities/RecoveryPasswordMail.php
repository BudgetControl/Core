<?php

namespace App\Mailer\Entities;

use Illuminate\Mail\Mailable;
use App\Mailer\Exceptions\MailExeption;
use Illuminate\Support\Facades\View;
use App\Mailer\Entities\Mail;

final class RecoveryPasswordMail extends Mail implements MailInterface
{

    public function __construct(string $subject, array $data)
    {
        $this->view = "recovery_password";
        $this->subject = $subject;

        parent::__construct($data);
    }
}
