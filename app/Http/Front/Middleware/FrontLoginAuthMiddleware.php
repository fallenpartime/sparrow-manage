<?php
/**
 * 前台登录验证
 */
namespace App\Http\Front\Middleware;

use Admin\Services\User\Processor\UserProcessor;
use Closure;
use Common\Config\SessionConfig;
use Frameworks\Tool\Http\SessionTool;
use Overtrue\Socialite\User as SocialiteUser;

class FrontLoginAuthMiddleware
{
    protected $sessionTool = null;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->sessionTool = new SessionTool($request);
        $sessionKey = SessionConfig::FRONT_USER_ID;
        $userId = $this->sessionTool->get($sessionKey);
        if (empty($userId)) {
            // TODO: 测试环境
            $this->wechatUser();

            // TODO: 正式
//            $redirectUrl = $request->fullUrl();
//            session(SessionConfig::FRONT_OAUTH_REDIRECT_URL, $redirectUrl);
//            return redirect('wechat.oauth.front');
        }
        return $next($request);
    }

    public function wechatUser()
    {
        $user = new SocialiteUser([
            'id' => time(),
            'name' => 'name_'.time(),
            'nickname' => 'nickname_'.time(),
            'avatar' => '/storage/20181105/bgnOSAvr0oozKHnvjs32aQNNsRTpOSqtsjUZsVse.jpeg',
            'email' => null,
            'original' => [],
            'provider' => 'WeChat',
        ]);
        $userId = $this->processWechatUser($user);
        if ($userId) {
            $this->sessionTool->set(SessionConfig::FRONT_USER_ID, $userId);
            $this->sessionTool->set(SessionConfig::FRONT_USER_INFO, $user);
        }
        return $user;
    }

    protected function processWechatUser($wechatUser)
    {
        if (empty($wechatUser)) {
            return 0;
        }
        $data = [
            'nick_name'         => array_get($wechatUser, 'nickname'),
            'openid'            => array_get($wechatUser, 'id'),
            'face'              => array_get($wechatUser, 'avatar'),
            'last_login_at'     => date('Y-m-d H:i:s'),
        ];
        list($status, $user) = (new UserProcessor())->insert($data);
        if ($status) {
            return $user->id;
        }
        return 0;
    }
}
