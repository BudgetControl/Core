<?php

namespace App\Mailer\Services;

use App\Mailer\Entities\BudgetMail;

class BudgetAlert extends MailService {

    private function __construct(array $data, string $view = 'budget_expired')
    {
        parent::__construct(new BudgetMail(
            $data,
            $view
        ));
    }

    public static function expired(array $data)
    {
        return new BudgetAlert($data);
    }

    public static function almostExpired(array $data)
    {
        return new BudgetAlert($data, 'budget_expired');
    }

}