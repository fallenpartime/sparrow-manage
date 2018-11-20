<?php
/**
 * 前台登录验证
 */
namespace App\Http\Front\Middleware;

use Closure;
use Common\Config\SessionConfig;

class FrontLoginAuthMiddleware
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
        $sessionKey = SessionConfig::FRONT_USER_ID;
        $userId = session($sessionKey);
        if (empty($userId)) {
            $redirectUrl = $request->getUri();
            session(SessionConfig::FRONT_OAUTH_REDIRECT_URL, $redirectUrl);
            return redirect('wechat.oauth.front');
        }
        return $next($request);
    }
}
