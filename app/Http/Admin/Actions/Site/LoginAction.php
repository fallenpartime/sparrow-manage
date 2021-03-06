<?php
/**
 * 登录控制器
 * Date: 2018/10/2
 * Time: 23:06
 */
namespace App\Http\Admin\Actions\Site;

use Admin\Action\BaseAction;
use Admin\Services\Auth\AuthService;
use Common\Config\SystemConfig;
use Common\Models\System\AdminUserInfo;
use Admin\Services\Authority\Integration\OwnerAuthoritiesIntegration;
use Admin\Services\Authority\Processor\AdminUserProcessor;
use Admin\Services\Authority\Processor\AdminUserRoleAccessProcessor;
use Frameworks\Tool\Cache\RedisTool;
use Wechat\Tool\WechatTool;

class LoginAction extends BaseAction
{
    public function run()
    {
        $authService = new AuthService($this->request);
        $authService->destroyLogin();
        $adminDomain = SystemConfig::ADMIN_DOMAIN;
        $currentDomain = url()->current();
        if (str_contains($currentDomain, $adminDomain)) {
            return $this->qrcodeLogin();
        }
        return $this->pwdLogin();
    }

    protected function qrcodeLogin()
    {
        $adminDomain = SystemConfig::ADMIN_DOMAIN;
        $siteDomain = SystemConfig::SITE_DOMAIN;
        $token  = md5(time().rand(100,999));
        $tokenKey = "edu:admin:login:{$token}";
        $redisTool = new RedisTool();
        $redisTool->hmset($tokenKey, ['token' => $token, 'site' => 'edu_admin', 'time' => time(), 'status' => 0], 3600);
//        $wechatTool = new WechatTool();
//        $wechatConfig = $wechatTool->getApp()->config;
//        $redirectUrl = urlencode($siteDomain."/wechat/oauth/admin?token={$token}");
//        $code_url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$wechatConfig->app_id
//            ."&redirect_uri={$redirectUrl}&response_type=code&scope=snsapi_userinfo"
//            ."&state={$token}#wechat_redirect";
        $code_url = $siteDomain."/wechat/oauth/admin?token={$token}";
        $check_url  = $adminDomain.'/admin/check?token='.$token;

        $result = [
            'token'     =>  $token,
            'code_url'  =>  $code_url,
            'check_url' =>  $check_url,
        ];
        return view('admin.site.scan', $result);
    }

    protected function parseRoleAccess($roleId)
    {
        $accesses = (new AdminUserRoleAccessProcessor())->getListByNo($roleId);
        if (empty($accesses)) {
            return [];
        }
        $list = [];
        foreach ($accesses as $access) {
            $groupNo = $access->group_no;
            $isLeader = $access->is_leader;
            $list[$groupNo] = ['no'=>$groupNo, 'is_leader'=>$isLeader];
        }
        return $list;
    }

    protected function pwdLogin()
    {
        $httpTool = $this->getHttpTool();
        $submit = $httpTool->getBothSafeParam('submit');
        if (empty($submit)) {
            return view('admin.site.loginpwd', []);
        }
        $username = $httpTool->getBothSafeParam('username');
        $pwd = $httpTool->getBothSafeParam('pwd');
        $userProcessor = new AdminUserProcessor();
        $user = $userProcessor->getSingleByName($username);
        if (empty($user)) {
            return view('admin.site.loginpwd', ['result_msg'=>'该用户不存在']);
        }
        if (md5($user->salt.$pwd) == $user->pwd) {
            $userId = $user->id;
            $name = $user->name;
            $owner = AdminUserInfo::with(['user', 'role', 'userAction'])->where('user_id', $userId)->first();
            if (empty($owner)) {
                return view('admin.site.loginpwd', ['result_msg'=>'登录信息不存在']);
            }
            if (!empty($owner) && $owner->is_admin==1) {
                $roleId = $owner->role_id;
                $isManger = $roleId == 1? 1: 0;
                $isSuper = $owner->is_super;
                $ts_list = [];
                if ($roleId > 0) {
                    list($stauts, $message, $ts_list) = (new OwnerAuthoritiesIntegration($owner))->process();
                }
                $groupList = $this->parseRoleAccess($roleId);
                $admin_info = array(
                    'userid' 	=> $userId,
                    'username'	=> $name,
                    'role_id'	=> $roleId,
                    'group_list'    => $groupList,
                    'is_manager'    => $isManger,
                    'is_super'  => $isSuper,
                );
                $httpTool->setSession('admin_info', $admin_info);
                $httpTool->setSession('ts_list', $ts_list);
//                return redirect('index');
                header("location: ".route('index'));
            }
            return view('admin.site.loginpwd', ['result_msg'=>'用户不允许登录']);
        }
        return view('admin.site.loginpwd', ['result_msg'=>'用户账号密码不正确']);
    }
}
