<?php
/**
 * 登录验证控制器
 * Date: 2018/10/2
 * Time: 23:10
 */
namespace App\Http\Admin\Actions\Site;

use Admin\Action\BaseAction;
use Admin\Services\Authority\Integration\OwnerAuthoritiesIntegration;
use Admin\Services\Authority\Processor\AdminUserRoleAccessProcessor;
use Common\Models\System\AdminUser;
use Common\Models\System\AdminUserInfo;
use Frameworks\Tool\Cache\RedisTool;
use Frameworks\Traits\ApiActionTrait;

class CheckAction extends BaseAction
{
    use ApiActionTrait;

    public function run()
    {
        $httpTool = $this->getHttpTool();
        $token = $httpTool->getBothSafeParam('token');
        if (empty($token)) {
            $this->errorJson(500, '参数缺失');
        }
        $tokenKey = "edu:admin:login:{$token}";
        $redisTool = new RedisTool();
        $tokenData = $redisTool->hgetall($tokenKey);
        if (empty($tokenData)) {
            $this->errorJson(500, '二维码已失效');
        }
        if (!isset($tokenData['phone']) || $tokenData['status'] == 0) {
            $this->errorJson(500, '请重新登录');
        }
        $phone = $tokenData['phone'];
        if (empty($phone)) {
            $this->errorJson(500, '未绑定电话');
        }
        $adminUser = AdminUser::where(['phone'=>$phone])->first();
        if (empty($adminUser)) {
            $this->errorJson(500, '后台用户不存在');
        }
        $owner = AdminUserInfo::with(['user', 'role', 'userAction'])->where('user_id', $adminUser->id)->first();
        if (empty($owner)) {
            $this->errorJson(500, '后台用户信息缺失');
        }
        if ($owner->is_admin==1) {
            $roleId = $owner->role_id;
            $isManger = $roleId == 1? 1: 0;
            $isSuper = $owner->is_super;
            $ts_list = [];
            if ($roleId > 0) {
                list($stauts, $message, $ts_list) = (new OwnerAuthoritiesIntegration($owner))->process();
            }
            $groupList = $this->parseRoleAccess($roleId);
            $admin_info = array(
                'userid' 	=> $adminUser->id,
                'username'	=> $adminUser->name,
                'role_id'	=> $roleId,
                'group_list'    => $groupList,
                'is_manager'    => $isManger,
                'is_super'  => $isSuper,
            );
            $httpTool->setSession('admin_info', $admin_info);
            $httpTool->setSession('ts_list', $ts_list);
            $this->successJson('', ['url'=>route('index')]);
        }
        $this->errorJson(500, '后台用户不允许登录');
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
}