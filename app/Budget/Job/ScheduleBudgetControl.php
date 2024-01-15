<?php
namespace App\Budget\Job;

use App\Budget\Domain\Model\Budget;
use App\Budget\Services\BudgetMamangerService;
use App\Budget\Services\BudgetNotificationService;
use App\User\Services\UserService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ScheduleBudgetControl implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->handle();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info("Control of exceeded budgets");
        $this->getBudget();
        return 1;
    }

    /**
     * get all budget is exceeded
     */
    private function getBudget()
    {
        $budgets = Budget::all();
        $service = new BudgetMamangerService();

        foreach($budgets as $budget)
        {
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
    }

    private function alertExpired(array $budget)
    {
        $to = $budget['user_email'];
        BudgetNotificationService::budgetExpired($budget,$to)->send();
    }

    private function alertAlmostExpired(array $budget)
    {
        $to = $budget['user_email'];
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
            "user_email" => $user['user_profile']['email']->email
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
