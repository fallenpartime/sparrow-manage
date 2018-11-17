<?php
/**
 * 后台验证
 * Date: 2018/10/2
 * Time: 22:39
 */
namespace Admin\Services\Auth;

use Frameworks\Tool\CompareTool;
use Frameworks\Tool\Http\SessionTool;
use Illuminate\Http\Request;

class AuthService
{
    protected $request = null;
    protected $adminInfo = [];
    protected $actionList = [];
    protected $currentAction = '';
    protected $session = null;
    public $isMaster = 0;
    public $isSuper = 0;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->_init($request);
    }

    protected function _clear()
    {
        $this->adminInfo = [];
        $this->actionList = [];
        $this->currentAction = '';
        $this->isMaster = 0;
        $this->isSuper = 0;
    }

    protected function _init(Request $request)
    {
        $this->_clear();
        $this->session = new SessionTool($request);
        $this->currentAction = $request->route()->getName();
        $this->initAdminInfo();
        $this->initActionList();
    }

    protected function initAdminInfo()
    {
        $this->adminInfo = $this->session->get('admin_info');
        $this->isMaster = $this->adminInfo['is_manager'];
        $this->isSuper = $this->adminInfo['is_super'];
    }

    protected function initActionList()
    {
        $this->actionList = $this->session->get('ts_list');
    }

    public function getAdminInfo()
    {
        return $this->adminInfo;
    }

    public function getActionList()
    {
        return $this->actionList;
    }

    public function validateLogin()
    {
        $loginStatus = false;
        $redirectUrl = route('admin.login');
        if (!empty($this->adminInfo)) {
            $loginStatus = true;
        } else {
            if ($this->request->ajax()) {
                $result = [
                    'code'  =>  500,
                    'msg'   =>  '请先登录'
                ];
                exit(json_encode($result));
            }
        }
        return [$loginStatus, $redirectUrl, $this->adminInfo];
    }

    public function validateCurrentAction()
    {
        list($status, $redirectUrl, $adminInfo) = $this->validateLogin();
        if (empty($status)) {
            return redirect($redirectUrl);
        }
        if ($this->isMaster) {
            return [true, ''];
        }
        $validate = $this->validateAction($this->currentAction);
        if ($validate) {
            return [true, ''];
        }
        if ($this->request->ajax()) {
            $result = [
                'code'  =>  500,
                'msg'   =>  '权限不足'
            ];
            exit(json_encode($result));
        }
        $redirectUrl = route('admin.warn');
        return [false, redirect($redirectUrl)];
    }

    /**
     * 对比操作
     * @param $action
     * @param $method 0-or 1-and
     * @return bool
     */
    public function validateAction($action, $method = 1)
    {
        if (empty($action)) {
            return false;
        }
        $actionList = $this->actionList;
        if (empty($actionList)) {
            return false;
        }
        if (is_array($action)) {
            return CompareTool::compareValues($method, CompareTool::METHOD_IN_ARRAY, $action, $actionList);
        }
        return in_array($action, $actionList);
    }

    /**
     * 注销登录session 销毁
     * @return bool
     */
    public function destroyLogin()
    {
        $this->session->remove('admin_info');
        $this->session->remove('ts_list');
        return true;
    }
}