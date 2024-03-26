<?php

namespace App\User\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class UserException extends Exception
{
    public function render(): Response
    {
        $error = "An error occurred on auth process";
        $errorCode = \Ramsey\Uuid\Uuid::uuid4()->toString();;
        $statusCode = empty($this->getCode()) ? 200 : $this->getCode();
        $file = $this->getFile();

        Log::error($errorCode.' '.$this->getMessage());
        return response(["error" => $error, "error_code" => $errorCode, "message" => $this->getMessage(), 'file' => $file], $statusCode);
    }
}
