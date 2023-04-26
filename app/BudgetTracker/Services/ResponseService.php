<?php
namespace App\BudgetTracker\Services;

use stdClass;

class ResponseService
{

    /**
     * @return array
     */
    public function __construct(
        public readonly array|object $data,
        public readonly string $message = "",
        public readonly string $errorCode = "",
        public readonly float $version = 2.0
    )
    {
    }
}