<?php

namespace App\Mailer\Entities;

use App\Mailer\Entities\Mail;

final class BudgetMail extends Mail implements MailInterface
{
    protected $dataValidation = [
        'user_name', 'budget_name', 'percentage', 'difference'
    ];
    
    public function __construct(array $data, string $view = 'budget')
    {
        $this->view = $view;
        $this->subject = "The ".$data['budget_name']." budget has been exceeded";

        parent::__construct($data);
    }
}
