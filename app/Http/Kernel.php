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
        \App\Http\Middleware\CheckForMaintenanceMode::class,
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
            'throttle:60,1',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
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
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'adminMiddleware' => \App\Http\Middleware\admin::class,
        'accountMiddleware' => \App\Http\Middleware\account::class,
        'productMiddleware' => \App\Http\Middleware\product::class,
        'orderMiddleware' => \App\Http\Middleware\order::class,
        //kiem tra xem co quyen xem bao cao doanh thu hay khong
        'revenueMiddleware' => \App\Http\Middleware\revenue::class,
        //middleware kiem tra xem nguoi dung co quyen xem danh sach nguoi dung hay khong
        'userMiddleware' => \App\Http\Middleware\user::class,
        //middleware cho ke toan
        'accountantMiddleware' => \App\Http\Middleware\accountant::class,
        //middleware cho saler
        'messageMiddleware' => \App\Http\Middleware\message::class,
        //middleware cho nguoi kiem duyet
        'acceptMiddleware' => \App\Http\Middleware\accept::class,
        //middleware cho admin edit nguoi dung
        'manageUserMiddleware' => \App\Http\Middleware\manageUser::class,
        //middleware chặn khi người dùng không có quyền xem danh sách bài viết
        'showListBlogMiddleware' => \App\Http\Middleware\showlistblog::class,
        //middleware chặn khi người dùng không có quyền thêm bài viết mới
        'addBlogMiddleware' => \App\Http\Middleware\blog::class,
    ];
}
