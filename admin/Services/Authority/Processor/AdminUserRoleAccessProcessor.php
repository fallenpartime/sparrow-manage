<?php
/**
 * 后台角色关联处理
 * Date: 2018/10/4
 * Time: 16:15
 */
namespace Admin\Services\Authority\Processor;

use Common\Models\System\AdminUserRoleAccess;
use Frameworks\Services\Basic\Processor\BaseProcessor;

class AdminUserRoleAccessProcessor extends BaseProcessor
{
    protected $tableName = 'admin_user_role_accesses';
    protected $tableClass = AdminUserRoleAccess::class;

    public function getListByNo($roleNo, $columns = [])
    {
        if (empty($roleNo)) {
            return '';
        }
        $where = ['role_no' => $roleNo];
        return $this->getList($where, $columns);
    }
}