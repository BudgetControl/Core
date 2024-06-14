<?php

require_once __DIR__ . "/../bootstrap/app.php";

$app = \Slim\Factory\AppFactory::create();

/**
 * The routing middleware should be added earlier than the ErrorMiddleware
 * Otherwise exceptions thrown from it will not be handled by the middleware
 */
require_once __DIR__ . "/../config/middleware.php";

require_once __DIR__ . "/../routes/api.php";

// Run app
$app->run();
