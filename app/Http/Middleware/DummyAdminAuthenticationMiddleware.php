<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DummyAdminAuthenticationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!(request()->header('sibling-api-key') == config('app.sibling_key') && request()->header('user-type') == 'admin'))
        {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        return $next($request);
    }
}
