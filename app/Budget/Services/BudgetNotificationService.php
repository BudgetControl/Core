<?php

namespace App\Budget\Services;

use App\Mailer\Services\BudgetAlert;

class BudgetNotificationService
{
    private BudgetAlert $mailer;
    private string $to;

    private function __construct(array $data, string $to)
    {
        $this->mailer = new BudgetAlert($data);
        $this->to = $to;
    }

    public static function build(array $data, string $to): self {
        return new BudgetNotificationService($data,$to);
    }

    public function send(): void
    {
        $this->mailer->send($this->to);
    }
}
