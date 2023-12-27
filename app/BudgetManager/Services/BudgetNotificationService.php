<?php

namespace App\BudgetManager\Services;

use App\BudgetManager\Domain\Entity\BudgetConfigurator;
use App\BudgetManager\Domain\Model\Budget;
use App\BudgetTracker\Enums\PlanningType;
use App\BudgetTracker\Models\Account;
use App\User\Services\UserService;

class BudgetNotificationService
{

    public function save(array $data): void
    {
        $configuration = new BudgetConfigurator(
            $data['balance'],
            PlanningType::from($data['pallingType']),
            @$data['type']
        );

        foreach ($data['account'] as $account) {
            $configuration->setAccount(Account::find($account));
        }

        if (!empty($data['id'])) {
            $budget = Budget::find($data['id']);
        } else {
            $budget = new Budget();
        }

        $budget->balance = $data['balance'];
        $budget->configuration = $configuration->toJson();
        $budget->user_id = UserService::getCacheUserID();
        $budget->save();
    }
}
