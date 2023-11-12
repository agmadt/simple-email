<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SimpleEmailToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->has('api_token')) {
            return response()->json([
                'message' => 'Unauthorized. Missing API Token.'
            ], 401);
        }

        if ($request->api_token != config('auth.api.token')) {
            return response()->json([
                'message' => 'Unauthorized. API Token Mismatch.'
            ], 401);
        }

        return $next($request);
    }
}
