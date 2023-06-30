<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use DivisionByZeroError;

class MathHelper
{


    /** get percentage
     * 
     * @param float $first
     * @param float $second
     * 
     * @return int
     */
    public static function percentage(float $first, float $second): int
    {
        try {
            $difference = abs($first - $second);
            $segno = ($first > $second) ? 1 : -1;
            $percentage = ($difference / $first) * 100 * $segno;
    
            return $percentage;

        } catch(DivisionByZeroError ) {

            return 0;
        }
        
    }

    /**
    * sum of costo
    * @param array $data
    * @return float
    */
    static public function sum(array $data): float
    {
      $cost = (float) 0.00;
      foreach ($data as $value) {
        $value = (array) $value;
        $cost += (float) $value['amount'];
      }
      return $cost;
    }
}
