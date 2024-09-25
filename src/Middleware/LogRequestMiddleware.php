<?php

namespace RequestLog\LogRequestPackage\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogRequestMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        Log::info('Requisição recebida', [
            'url' => $request->fullUrl(),
            'metodo' => $request->method(),
            'dados' => $request->all(),
            'cabecalhos' => $request->headers->all(),
        ]);

        return $next($request);
    }
}
