<?php

namespace App\Mailer\Entities;

use App\Mailer\Entities\Mail;

final class BudgetMail extends Mail implements MailInterface
{
    protected $dataValidation = [
        'name', 'budget_name', 'amount', 'budget'
    ];
    
    public function __construct(array $data)
    {
        $this->view = "budget";
        $this->subject = "The ".$data['budget']." budget has been exceeded";

        parent::__construct($data);
    }
}
