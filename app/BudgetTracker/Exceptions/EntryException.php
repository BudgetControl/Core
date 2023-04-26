<?php

namespace App\BudgetTracker\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EntryException extends Exception
{
    public function render(Request $request): Response
    {
        $status = 500;
        $error = "An error occurred on Entry services";
        $help = "Contact the sales team to verify";
        $errorCode = uniqid();

        return response(["error" => $error, "help" => $help, "error_code" => $errorCode], $status);
    }
}
