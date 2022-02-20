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
     * @var array
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\TrustProxies::class,
        \Fruitcake\Cors\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:1000,1',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'adminRole' => [
            'checkloged' => \App\Http\Middleware\CheckLogin::class,
            'admin' => \App\Http\Middleware\CheckAdmin::class,
        ],

        'facultyRole' => [
            'checkloged' => \App\Http\Middleware\CheckLogin::class,
            'deanfaculty' => \App\Http\Middleware\CheckFacultyOfDean::class,
        ],

        'formteacherRole' => [
            'checkloged' => \App\Http\Middleware\CheckLogin::class,
            'formteacher' => \App\Http\Middleware\CheckFormTeacher::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'checkloged' => \App\Http\Middleware\CheckLogin::class,
        'checkss' => \App\Http\Middleware\CheckSession::class,
        'checklogedst' => \App\Http\Middleware\CheckLoginStudent::class,
        'checkssst' => \App\Http\Middleware\CheckSessionStudent::class,
        'deanfaculty' => \App\Http\Middleware\CheckFacultyOfDean::class,
        'formteacher' => \App\Http\Middleware\CheckFormTeacher::class,
        'lecturer' => \App\Http\Middleware\CheckLecturer::class,
        'admin' => \App\Http\Middleware\CheckAdmin::class,
    ];
}
