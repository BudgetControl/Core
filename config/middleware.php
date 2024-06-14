<?php

// ##### APPLICATION MIDDLEWARE ######
$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();

/**
 * error middleware
 */
$errorMiddleware = $app->addErrorMiddleware(true, true, true, $logger);
$errorMiddleware->setDefaultErrorHandler(function (\Slim\Http\ServerRequest $request, Throwable $e) use ($logger, $app) {

    $procId = uniqid();
    $logger->error($e, [
        'request' => $_SERVER['REQUEST_URI'],
        'procid' => $procId
    ]);

    $statusError = [
        'id' => $procId,
        'status' => empty($e->getCode()) ? 500 : $e->getCode(),
        'detail' => $e->getMessage()
    ];

    $payload = ['error' => $statusError];
    if (env("APP_DEBUG") == "true") {
        $payload['error']['trace'] = $e->getTrace();
    }

    $code = (int) $e->getCode();
    if ($code < 100 || $code > 599) {
        $code = 500;
    }

    return response($payload, $code);
});