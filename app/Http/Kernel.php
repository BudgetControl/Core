<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        // \App\User\Middleware\TrustHosts::class,
        \App\User\Middleware\TrustProxies::class,
        \Illuminate\Http\Middleware\HandleCors::class,
        \App\User\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\User\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        'web' => [
            \App\User\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\User\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            \Illuminate\Routing\Middleware\ThrottleRequests::class.':api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\User\Middleware\JwtAuthenticate::class,
        ],

        'stats' => [
            \Illuminate\Routing\Middleware\ThrottleRequests::class.':stats',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\User\Middleware\JwtAuthenticate::class,
        ],

        'chart' => [
            \Illuminate\Routing\Middleware\ThrottleRequests::class.':chart',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\User\Middleware\JwtAuthenticate::class,
        ],
        
        'auth' => [
            \Illuminate\Routing\Middleware\ThrottleRequests::class.':stats',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
        
        'mailer' => [
            \Illuminate\Routing\Middleware\ThrottleRequests::class.':mailer',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\User\Middleware\JwtAuthenticate::class,
        ],
        
        'budget' => [
            \Illuminate\Routing\Middleware\ThrottleRequests::class.':budget',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's middleware aliases.
     *
     * Aliases may be used to conveniently assign middleware to routes and groups.
     *
     * @var array<string, class-string|string>
     */
    protected $middlewareAliases = [
        'auth' => \App\User\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\User\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \App\User\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'auth.jwt' => \App\User\Middleware\JwtAuthenticate::class,

    ];
}
