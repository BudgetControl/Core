<?php
namespace App\BudgetTracker\Logger;

use Monolog\Logger;
use Logtail\Monolog\LogtailHandler;

class Logtail {

    public function __invoke()
    {
        $logger = new Logger("logtail-source");
        $logger->pushHandler(new LogtailHandler(env('LOG_TOKEN')));

    }
}