<?php

namespace App\Mailer\Services;

use App\Mailer\Entities\AuthMail;

class BudgetAlert extends MailService {

    public function __construct(string $subject, array $data)
    {
        parent::__construct(new AuthMail(
            $subject,
            $data
        ));
    }

}