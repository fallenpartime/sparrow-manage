<?php
/**
 * 登录控制器
 * Date: 2018/10/2
 * Time: 23:06
 */
namespace App\Http\Admin\Actions\Site;

use Admin\Actions\BaseAction;
use Admin\Auth\AuthService;
use Admin\Models\System\AdminUserInfo;
use Admin\Services\Authority\Integration\OwnerAuthoritiesIntegration;
use Admin\Services\Authority\Processor\AdminUserProcessor;
use Admin\Services\Authority\Processor\AdminUserRoleAccessProcessor;

class LoginAction extends BaseAction
{
    public function run()
    {
        $authService = new AuthService($this->request);
        $authService->destroyLogin();
        return $this->pwdLogin();
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
                header("location: ".route('index'));
            }
            return view('admin.site.loginpwd', ['result_msg'=>'用户不允许登录']);
        }
        return view('admin.site.loginpwd', ['result_msg'=>'用户账号密码不正确']);
    }
}
