<?php

namespace App\Budget\Services;

use App\Mailer\Services\BudgetAlert;

class BudgetNotificationService
{
    private BudgetAlert $mailer;
    private string $to;

    const EXPIRED = 1;
    const ALMOST_EXPIRED = 2;

    private function __construct(array $data, string $to, $type)
    {
        switch($type) {
            case self::EXPIRED :
                $this->mailer = BudgetAlert::expired($data);
                break;
            case self::ALMOST_EXPIRED :
                $this->mailer = BudgetAlert::almostExpired($data);
                break;
        }

        $this->to = $to;
    }

    public static function budgetExpired(array $data, string $to): self {
        return new BudgetNotificationService($data,$to,self::EXPIRED);
    }

    public static function budgetAlmostExpired(array $data, string $to): self {
        return new BudgetNotificationService($data,$to,self::ALMOST_EXPIRED);
    }

    public function send(): void
    {
        $this->mailer->send($this->to);
    }
}
