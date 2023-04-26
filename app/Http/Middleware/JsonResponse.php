<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JsonResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $jsonResponse = new \stdClass();
        $jsonResponse->data = $response;
        $jsonResponse->message = null;
        $jsonResponse->version = 3.0;
        $jsonResponse->time = time();


        return response((array) $jsonResponse);
    }
}
