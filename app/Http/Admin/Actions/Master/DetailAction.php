<?php
/**
 * 用户详情
 * Date: 2018/10/6
 * Time: 0:27
 */
namespace App\Http\Admin\Actions\Master;

use Admin\Actions\BaseAction;
use Admin\Models\System\AdminUserInfo;
use Admin\Models\System\AdminUserRole;
use Admin\Services\Authority\Processor\AdminUserInfoProcessor;
use Admin\Services\Authority\Processor\AdminUserProcessor;
use Admin\Services\Log\LogService;
use Admin\Traits\ApiActionTrait;
use Frameworks\Tool\Http\HttpConfig;

class DetailAction extends BaseAction
{
    use ApiActionTrait;

    protected $_user = null;
    protected $_owner = null;

    public function run()
    {
        $httpTool = $this->getHttpTool();
        $id = $httpTool->getBothSafeParam('id', HttpConfig::PARAM_NUMBER_TYPE);
        $workNo = $httpTool->getBothSafeParam('work_no', HttpConfig::PARAM_NUMBER_TYPE);
        if (!empty($id)) {
            $this->_owner = AdminUserInfo::find($id);
            if (!empty($this->_owner)) {
                $this->_user = $this->_owner->user;
            }
        }
        if ($workNo == 1 || $workNo == 2) {
            if ($workNo == 1) {
                return $this->showInfo();
            } else {
                $this->process();
            }
        }
        $this->errorJson(500, '请求类型不匹配');
    }

    protected function showInfo()
    {
        $result = [
            'record'            =>  $this->_owner,
            'user'              =>  $this->_user,
            'roles'             =>  AdminUserRole::all(),
            'menu'  =>  ['manageCenter', 'ownerManage', 'ownerInfo'],
            'actionUrl'         => route('ownerInfo', ['work_no'=>2]),
            'redirectUrl'       => route('owners'),
        ];
        return $this->createView('admin.system.owner.detail', $result);
    }

    protected function updateUser($userData, $ownerData)
    {
        if(empty($this->_user)){
            $this->errorJson(500, '后台用户基本信息不存在');
        }
        if(empty($this->_owner)){
            $this->errorJson(500, '后台用户信息不存在');
        }
        LogService::adminLog($this->request, 2, $this->_user->id, '编辑管理员', $this->getAuthService()->getAdminInfo());
        $adminUserProcessor = new AdminUserProcessor();
        list($res, $errorId, $message) = $this->validateRepeat($adminUserProcessor, $userData, 1);
        if ($res == false) {
            $this->errorJson(500, $message);
        }
        $adminUserProcessor->update($this->_user->id, $userData);
        (new AdminUserInfoProcessor())->update($this->_owner->id, $ownerData);
        $this->successJson();
    }

    protected function saveUser($userData, $ownerData)
    {
        $adminUserProcessor = new AdminUserProcessor();
        list($res, $errorId, $message) = $this->validateRepeat($adminUserProcessor, $userData);
        if ($res == false) {
            $this->errorJson(500, $message);
        }
        list($status, $user) = $adminUserProcessor->insert($userData);
        if (empty($user)) {
            $this->errorJson(500, '后台用户基本信息创建失败');
        }
        $ownerData['user_id'] = $user->id;
        $userInfoProcessor = new AdminUserInfoProcessor();
        list($status, $userInfo) = $userInfoProcessor->insert($ownerData);
        if ($status) {
            $this->successJson();
        }
        LogService::adminLog($this->request, 1, $user->id, '添加管理员', $this->getAuthService()->getAdminInfo());
        $this->errorJson(500, '后台用户信息创建失败');
    }

    protected function changPassword($pwd, $data)
    {
        $salt   =   md5(rand());
        $md5pwd =   md5($salt . $pwd);
        $data['pwd']    =   $md5pwd;
        $data['salt']   =   $salt;
        return $data;
    }

    protected function initOwnerData()
    {
        $httpTool = $this->getHttpTool();
        $params = $httpTool->getParams();
        $username = $httpTool->getBothSafeParam('name');
        $phone = $httpTool->getBothSafeParam('phone');
        $changePwd = $httpTool->getBothSafeParam('change_pwd', HttpConfig::PARAM_NUMBER_TYPE);
        $pwd = $httpTool->getBothSafeParam('pwd');
        $roleId = $httpTool->getBothSafeParam('role_id', HttpConfig::PARAM_NUMBER_TYPE);
//        $isOwner = $httpTool->getBothSafeParam('is_owner', HttpConfig::PARAM_NUMBER_TYPE);
        $isAdmin = $httpTool->getBothSafeParam('is_admin', HttpConfig::PARAM_NUMBER_TYPE);
        $username = trim($username);
        $phone = trim($phone);
        $phone = trim($phone);
        $ownerData = [
            'role_id'   =>  !empty($roleId)? $roleId: 0,
            'is_owner'  =>  1,
            'is_admin'  =>  !empty($isAdmin)? $isAdmin: 0,
        ];
        $userData = [
            'name'      =>  $username,
            'phone'     =>  $phone,
        ];
        if (empty($this->_user)) {
            if (!empty($pwd)) {
                $userData = $this->changPassword($pwd, $userData);
            }
        } else {
            if (!empty($changePwd) && !empty($pwd)) {
                $userData = $this->changPassword($pwd, $userData);
            }
        }
        if (isset($params['is_super'])) {
            $isSuper = $httpTool->getBothSafeParam('is_super', HttpConfig::PARAM_NUMBER_TYPE);
            $ownerData['is_super'] = !empty($isSuper)? $isSuper: 0;
        }
        return [$userData, $ownerData];
    }

    protected function validateRepeat(AdminUserProcessor $processor, $data, $isUpdate = 0)
    {
        $record = $processor->getSingleByName($data['name']);
        if (!empty($record)) {
            if ($isUpdate) {
                if ($record->id != $this->_user->id) {
                    $this->errorJson(500, '后台用户名已存在');
                }
            } else {
                $this->errorJson(500, '后台用户名已存在');
            }
        }
        $record = $processor->getSingleByPhone($data['phone']);
        if (!empty($record)) {
            if ($isUpdate) {
                if ($record->id != $this->_user->id) {
                    $this->errorJson(500, '后台用户电话已存在');
                }
            } else {
                $this->errorJson(500, '后台用户电话已存在');
            }
        }
        return [true, 0, ''];
    }

    protected function process()
    {
        $httpTool = $this->getHttpTool();
        $id = $httpTool->getBothSafeParam('id', HttpConfig::PARAM_NUMBER_TYPE);
        $username = $httpTool->getBothSafeParam('name');
        $username = trim($username);
        $phone = $httpTool->getBothSafeParam('phone');
        $phone = trim($phone);
        $roleId = $httpTool->getBothSafeParam('role_id', HttpConfig::PARAM_NUMBER_TYPE);
        $isAdmin = $httpTool->getBothSafeParam('is_admin', HttpConfig::PARAM_NUMBER_TYPE);
        if(empty($username)){
            $this->errorJson(500, '用户名为空');
        }
        if(empty($phone)){
            $this->errorJson(500, '电话不能为空');
        }
        if(empty($roleId) && !empty($isAdmin)){
            $this->errorJson(500, '未配置角色前不允许登录');
        }
        if (!empty($id) && empty($this->_owner)) {
            $this->errorJson(500, '记录不存在');
        }
        list($userData, $ownerData) = $this->initOwnerData();
        $res = empty($id)? $this->saveUser($userData, $ownerData): $this->updateUser($userData, $ownerData);
        if ($res) {
            $this->successJson();
        }
        $this->errorJson(500, '提交失败');
    }
}
