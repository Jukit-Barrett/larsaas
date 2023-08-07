<?php

namespace Mrzkit\LaravelEloquentEnhance\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForceAcceptJson
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $request->headers->set('Accept', 'application/json');

        return $next($request);
    }
}
