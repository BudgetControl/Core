<?php

namespace App\Mailer\Exceptions;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class MailExeption extends Exception
{
    public function render(): Response
    {
        $error = "An error occurred on Mailer services";
        $errorCode = \Ramsey\Uuid\Uuid::uuid4()->toString();;
        $statusCode = empty($this->getCode()) ? 200 : $this->getCode();
        $file = $this->getFile();

        Log::critical($errorCode.' '.$this->getMessage());
        return response(["error" => $error, "error_code" => $errorCode, "message" => $this->getMessage(), 'file' => $file], $statusCode);
    }
}
