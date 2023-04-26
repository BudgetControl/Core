<?php

namespace App\BudgetTracker\Helpers;

use Illuminate\Support\Facades\Log;

class MathHelper
{
    /**
    * return percentage of Sum
    * @param int $from
    * @param int $to
    * @return int
    */
    static public function getPercentage(int $from, int $to): int
    {
      try{

        $percent = $to * 100;
        $percent = $percent / 100;

      } catch(\DivisionByZeroError $e) {
        Log::warning($e);
        $percent = 0;
        
      }

      return round($percent,2);
    }

    /**
    * sum of costo
    * @param \Illuminate\Database\Eloquent\Collection|array|\App\BudgetTracker\Models\Entry $data
    * @return int
    */
    static public function sum( \Illuminate\Database\Eloquent\Collection|array|\App\BudgetTracker\Models\Entry $data): int
    {
      $cost = 0;
      foreach ($data as $value) {
        $cost = $value->amount + $cost;
      }
      return round($cost,2);
    }
}
