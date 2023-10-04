<?php

namespace App\BudgetTracker\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class EntryException extends Exception
{
    public function render(): Response
    {
        $error = "An error occurred on Entry services";
        $errorCode = uniqid();
        $statusCode = empty($this->getCode()) ? 200 : $this->getCode();
        $file = $this->getFile();

        Log::critical($errorCode.' '.$this->getMessage());
        return response(["error" => $error, "error_code" => $errorCode, "message" => $this->getMessage(), 'file' => $file], $statusCode);
    }
}
