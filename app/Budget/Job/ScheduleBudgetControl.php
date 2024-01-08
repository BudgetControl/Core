<?php
namespace App\Budget\Job;

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
    }

    /**
     * get all budget is exceeded
     */
    private function getBudget()
    {
        $service = new BudgetMamangerService();
        $budgets = $service->retriveBudgetsAmount();
        foreach($budgets as $field)
        {
            $budget = $field['budget'];
            $amount = $field['amount'];

            //recupero e sommo

            if($amount > $budget) {
                $this->alert($field);
            }
        }
    }

    /**
     * send email if is exceeded
     */
    private function alert(array $budget)
    {
        $user = UserService::getSettings();

        $data = [
            'amount' => $budget['amount'],
            'budget' => $budget['budget'],
            'budget_name' => $budget['name'],
            'name' => $user['user_profile']['name']
        ];

        $to = $user['user_profile']['email'];

        BudgetNotificationService::build($data,$to)->send();
       
    }

}
