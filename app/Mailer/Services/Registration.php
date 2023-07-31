<?php

namespace App\Mailer\Services;

use App\Mailer\Entities\AuthMail;

class Registration extends MailService {

    public function __construct(array $data)
    {
        parent::__construct(new AuthMail(
            "Welcome to ".env("APP_NAME", "Budget Control"),
            $data
        ));
    }

}