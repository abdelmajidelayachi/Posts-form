<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTMiddleware
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
        $message = '';
        try {
            // check validation of the token
            JWTAuth::parseToken()->authenticate();
            return $next($request);
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            $message = 'Token expired';
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            $message = 'Invalid token';
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            $message = 'Provide token';
        }
        return response()->json(['success' => false, 'message' => $message]);
    }
}
