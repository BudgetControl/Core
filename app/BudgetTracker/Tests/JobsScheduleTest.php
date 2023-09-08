<?php

namespace Tests\Feature;

use App\BudgetTracker\Enums\AccountType;
use Tests\TestCase;
use App\BudgetTracker\Models\Account;
use App\BudgetTracker\Jobs\ActivatePlannedEntries;
use App\BudgetTracker\Jobs\InsertPlannedEntry;

class JobsScheduleTest extends TestCase
{
    //64b54cc5677e0_job

    /**
     * A basic feature test example.
     */
    public function test_job_activate_entry_planned_data(): void
    {
        $job = new ActivatePlannedEntries();
        $job->handle();

        $this->assertDatabaseHas('entries',[
            'uuid' => '64b54cc5677e0_job',
            'planned' => 0
        ]);

    }
   
}
