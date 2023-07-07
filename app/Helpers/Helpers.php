<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use DivisionByZeroError;

class Helpers
{

    public static function color()
    {
        $hex = '';
        for ($i = 0; $i < 6; $i++) {
            $hex .= dechex(mt_rand(0, 15));
        }
        return '#'.$hex;
    }

}
