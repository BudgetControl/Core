<?php

namespace Database\Seeders;

use App\BudgetTracker\Models\Account;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\BudgetTracker\Models\Incoming;
use \App\BudgetTracker\Models\Labels;
use Faker\Provider\DateTime;

class IncomingSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $usrIdDemo =config('app.config.demo_userid');

        Incoming::factory(100)->create();

        Incoming::factory(1)->create([
            'date_time' => "2023-04-12 20:10:00"
        ]);

        Incoming::factory(1)->create([
            'date_time' => "2022-04-12 20:10:00"
        ]);

        Incoming::factory(5)->create(
            [
                'planned' => 1,
                'date_time' => DateTime::dateTimeBetween('now','+2 months')
            ]
        );

        $labels = Labels::factory(1)->create();

        Incoming::factory(1)->create([
            'uuid' => '64b54cc566d77_test',
            'account_id' => Account::where('user_id', $usrIdDemo)->get('id')[0]->id,
            'amount' => 1000,
            'planned' => 0,
            'date_time' => '2023-12-30'
        ]);

        Incoming::factory(1)->create([
            'uuid' => '64b54cc566d77_balancetest',
            'account_id' => Account::where('user_id', $usrIdDemo)->get('id')[1]->id,
            'amount' => 1000,
            'planned' => 0,
            'date_time' => '2023-12-30',
            'confirmed' => 1
        ]);

        Incoming::where('user_id',$usrIdDemo)->get()->each(function ($incoming) use ($labels) {
            $incoming->label()->saveMany($labels);
        });

        
    }
}
