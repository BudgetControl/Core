<?php

namespace App\Mailer\Services;

use App\Mailer\Entities\BudgetMail;

class BudgetAlert extends MailService {

    public function __construct(array $data)
    {
        parent::__construct(new BudgetMail(
            $data
        ));
    }

}