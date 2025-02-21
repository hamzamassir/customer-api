<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BasicAuth
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
        $auth = $request->header('Authorization');

        if (empty($auth) || !str_starts_with($auth, 'Basic ')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $credentials = explode(':', base64_decode(substr($auth, 6)));

        if ($credentials[0] === 'admin' && $credentials[1] === '123456') {
            return $next($request);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }
}
