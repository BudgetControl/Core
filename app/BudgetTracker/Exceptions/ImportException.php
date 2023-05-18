<?php

namespace App\BudgetTracker\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class ImportException extends Exception
{
    public function render(Request $request): Response
    {
        $status = 500;
        $error = "An error occurred during import service";
        $help = "Contact the IT team to verify";
        $errorCode = uniqid();

        Log::critical($errorCode.' '.$error);
        return response(["error" => $error, "help" => $help, "error_code" => $errorCode], $status);
    }
}
