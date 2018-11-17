<?php
/**
 * 角色权限列表
 * Date: 2018/10/11
 * Time: 10:57
 */
namespace Admin\Services\Authority\Integration;

use Frameworks\Services\Basic\Processor\BaseWorkProcessor;

class RoleAuthoritiesIntegration extends BaseWorkProcessor
{
    protected $_role = null;

    public function __construct($role)
    {
        $this->_init($role);
    }

    public function _init($role)
    {
        $this->_role = $role;
        $this->status = 0;
        return $this;
    }

    public function process()
    {
        if (empty($this->_role)) {
            return $this->parseResult('角色信息为空', []);
        }
        $roleActions = $this->getRoleActions();
        $this->status = 1;
        return $this->parseResult('', $roleActions);
    }

    protected function getGroupActions()
    {
        $groupActions = [];
//        if (!empty($this->_role)) {
//            $accesses = $this->_role->accesses;
//            if (!empty($accesses)) {
//                foreach ($accesses as $access) {
//                    $groupActionList = [];
//                    $group = $access->group;
//                    if (!empty($group) && !empty($group->actions)) {
//                        $groupActionList = json_decode($group->actions, true);
//                    }
//                    $groupActions = array_merge($groupActions, $groupActionList);
//                }
//            }
//        }
//        $groupActions = array_unique($groupActions);
        return $groupActions;
    }

    protected function getRoleActions()
    {
        $groupActions = $this->getGroupActions();
        $roleActions = [];
        if (!empty($this->_role) && !empty($this->_role->actions)) {
            $roleActions = json_decode($this->_role->actions, true);
        }
        $roleActions = array_merge($roleActions, $groupActions);
        $roleActions = array_unique($roleActions);
        return $roleActions;
    }
}
