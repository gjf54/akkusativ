<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AddBearerToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {   
        if($request->bearerToken()) return $next($request);

        $c_n = env('AUTH_COOKIE_NAME');

        if($request->hasCookie($c_n)) {
            $t = $request->cookie($c_n);

            $request->headers->add([
                'Authorization' => 'Bearer ' . $t,
                'Accept' => 'application/json',
            ]);
        };

        return $next($request);
    }
}
