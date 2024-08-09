<?php
/**
 * This file is a helper file that contains various functions.
 */

if(!function_exists('config')) {
    function confing(string $key, string $value): string {
        return $_ENV[$key] ?? $value;
    }
}

if(!function_exists('response')) {
    function response(array|\Illuminate\Database\Eloquent\Collection $dataResponse, int $statusCode = 200, array $headers=[]): \Psr\Http\Message\ResponseInterface {
        if($dataResponse instanceof \Illuminate\Database\Eloquent\Collection) {
            $dataResponse = $dataResponse->toArray();
        }
        
        $response = new \Slim\Psr7\Response();

        $jsonData = json_encode($dataResponse);
        if ($jsonData === false) {
            $errorResponse = new \Slim\Psr7\Response();
            $errorResponse->getBody()->write('Errore nella codifica JSON dei dati');
            return $errorResponse->withStatus(500);
        }
        
        $response->getBody()->write($jsonData);

        foreach ($headers as $key => $value) {
            $response = $response->withHeader($key, $value);
        }
        
        return $response->withHeader('Content-Type', 'application/json')->withStatus($statusCode);
    }
}

// More functions...
