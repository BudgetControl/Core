<?php


//setup log level from env
switch(env('APP_LOG_LEVEL','debug')) {
    case 'debug':
        $logLevel = \Monolog\Level::Debug;
        break;
    case 'info':
        $logLevel = \Monolog\Level::Info;
        break;
    case 'notice':
        $logLevel = \Monolog\Level::Notice;
        break;
    case 'warning':
        $logLevel = \Monolog\Level::Warning;
        break;
    case 'error':
        $logLevel = \Monolog\Level::Error;
        break;
    case 'critical':
        $logLevel = \Monolog\Level::Critical;
        break;
    case 'alert':
        $logLevel = \Monolog\Level::Alert;
        break;
    case 'emergency':
        $logLevel = \Monolog\Level::Emergency;
        break;
    default:
        $logLevel = \Monolog\Level::Debug;
}

//setup log with BetterStack
$logName = env('APP_NAME','BudgetControl');
$logger = new \Monolog\Logger(env('LOG_NAME', $logName));

// log on FS
$logPath = env('APP_LOG_PATH',__DIR__.'/../storage/logs/log-'.date("Ymd").'.log');
$streamHandler = new \Monolog\Handler\StreamHandler($logPath, $logLevel);

$formatter = new \Monolog\Formatter\LineFormatter('[%channel%][%level_name%] %message% %context% %extra%\n');
$streamHandler->setFormatter($formatter);
$logger->pushHandler($streamHandler);

// log on Logtail only in prod
if(env('APP_ENV') == 'prod') {
    $logger->pushHandler(new \Logtail\Monolog\LogtailHandler(env('LOGTAIL_API_KEY'), $logLevel));
}