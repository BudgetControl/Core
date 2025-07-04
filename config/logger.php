<?php
$logChannel = env('LOG_CHANNEL', 'file');

// Configurazione dei livelli di log con mappatura più efficiente
$logLevels = [
    'debug' => \Monolog\Level::Debug,
    'info' => \Monolog\Level::Info,
    'notice' => \Monolog\Level::Notice,
    'warning' => \Monolog\Level::Warning,
    'error' => \Monolog\Level::Error,
    'critical' => \Monolog\Level::Critical,
    'alert' => \Monolog\Level::Alert,
    'emergency' => \Monolog\Level::Emergency,
];

$logLevel = $logLevels[strtolower(env('APP_LOG_LEVEL', 'debug'))] ?? \Monolog\Level::Debug;

// Inizializzazione logger con controllo più robusto sul nome dell'app
$appName = env("APP_NAME", "BudgetControl");
if (empty(trim($appName))) {
    $appName = "BudgetControl";
}
$logger = new \Monolog\Logger($appName);

// Configurazione handler per file di log
if($logChannel === 'file') {
    $logPath = env('APP_LOG_PATH', __DIR__.'/../storage/logs/log-'.date("Y-m-d").'.log');
    $streamHandler = new \Monolog\Handler\StreamHandler($logPath, $logLevel);
}

if($logChannel === 'stderr') {
    $streamHandler = new \Monolog\Handler\StreamHandler('php://stderr', $logLevel); // Scrivi su stderr
} 

// Configurazione Logtail solo in produzione con controllo più robusto
if ($logChannel === 'logtail' && env('APP_ENV') === 'production') {
    $logtailApiKey = env('LOGTAIL_API_KEY');
    if (!empty($logtailApiKey)) {
        $streamHandler = new \Logtail\Monolog\LogtailHandler($logtailApiKey, $logLevel);
    } else {
        $logger->warning('Logtail API key is missing - skipping Logtail integration');
    }
}

$formatter = new \Monolog\Formatter\LineFormatter(
    "[%datetime%] %level_name%: %message% %context% %extra%\n",
    "Y-m-d H:i:s.v", // Formato timestamp più preciso
    true, // Allow inline line breaks
    true  // Ignore empty context and extra
);

$formatter->includeStacktraces(true);
$formatter->setJsonPrettyPrint(true);
$streamHandler->setFormatter($formatter);
$logger->pushHandler($streamHandler);

