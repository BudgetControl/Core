<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class SwitchDatabase
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Cache::get(user_ip());

        if ($user) {
            $database_name = $user->database_name;
            Config::set(['database.connections.mysql.database' => $database_name]);
            DB::purge('mysql');
            DB::reconnect('mysql');
        }

        return $next($request);
    }
}
