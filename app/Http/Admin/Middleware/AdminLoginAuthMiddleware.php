<?php

namespace App\Http\Admin\Middleware;

use Admin\Auth\AuthService;
use Closure;

class AdminLoginAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $authService = new AuthService($request);
        list($status, $redirectUrl, $adminInfo) = $authService->validateLogin();
        if ($status) {
            return $next($request);
        }
        return redirect($redirectUrl);
    }
}
