<?php
namespace App\Budget\Job;

use App\Budget\Domain\Model\Budget;
use App\Budget\Services\BudgetMamangerService;
use App\Budget\Services\BudgetNotificationService;
use App\BudgetTracker\Jobs\BudgetControlJobs;
use App\User\Services\UserService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use App\User\Models\User;

class ScheduleBudgetControl extends BudgetControlJobs implements ShouldQueue
{

    /**
     * get all budget is exceeded
     */
    public function job(): void
    {
        Log::info("Control of exceeded budgets");

        $budgets = Budget::all();
        $service = new BudgetMamangerService();

        foreach($budgets as $budget)
        {
            //setup user cache for scheduled job
            $user = User::find($budget->workspace_id);
            UserService::setUserCache($user);

            if($this->isValid($budget) === true) {
                if($service->isExpired($budget->id)) {
                    Log::debug("Budget is expired with ID ".$budget->id);
                    $this->alertExpired(
                        $this->buildData($service->retriveBudgetAmount($budget->id))
                    );
                }
    
                if($service->isAlmostExpired($budget->id)) {
                    Log::debug("Budget is almost expired with ID ".$budget->id);
                    $this->alertAlmostExpired(
                        $this->buildData($service->retriveBudgetAmount($budget->id))
                    );
                }
            }

        }
        UserService::clearUserCache();
    }

    private function alertExpired(array $budget)
    {
        $to = $budget['user_email'];
        $budget['className'] = 'critical';
        Log::debug("budgetExpired for $to");
        BudgetNotificationService::budgetExpired($budget,$to)->send();
    }

    private function alertAlmostExpired(array $budget)
    {
        $to = $budget['user_email'];
        $budget['className'] = 'warning';
        BudgetNotificationService::budgetAlmostExpired($budget,$to)->send();
    }

    private function buildData(array $budget)
    {
        $user = UserService::getSettings();
        return [
            "budget_name" => $budget['config']->name,
            "percentage" => $budget['percentage'],
            "period" => $budget['config']->period,
            "difference" => $budget['difference'],
            "user_name" => $user['user_profile']['name'],
            "user_email" => $user['user_profile']['email']->email,
            "currency" => $budget['currency']
        ];
    }

    private function isValid(Budget $budget): bool
    {
        if($budget->notification == false) {
            return false;
        }

        $config = json_decode($budget->configuration);
        if(!is_null($config->end_date)) {
            if(date("Y-m-d", time()) > $config->end_date) {
                return false;
            }
        }

        return true;
    }

}
