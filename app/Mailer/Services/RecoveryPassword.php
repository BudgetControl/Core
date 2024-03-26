<?php

namespace App\Mailer\Services;

use App\Mailer\Entities\AuthMail;

class RecoveryPassword extends MailService {

    public function __construct(array $data)
    {
        parent::__construct(new AuthMail("Recovery password",$data));
    }

}