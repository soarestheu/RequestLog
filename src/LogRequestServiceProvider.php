<?php

namespace RequestLog\LogRequestPackage;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use RequestLog\LogRequestPackage\Middleware\LogRequestMiddleware;

class LogRequestServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        // Registrar o middleware de forma global ou para uso posterior
        $router->aliasMiddleware('log.request', LogRequestMiddleware::class);
        
        // Se quiser aplicar globalmente o middleware (em todas as rotas), use:
        // $router->pushMiddlewareToGroup('web', LogRequestMiddleware::class);
        // $router->pushMiddlewareToGroup('api', LogRequestMiddleware::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
