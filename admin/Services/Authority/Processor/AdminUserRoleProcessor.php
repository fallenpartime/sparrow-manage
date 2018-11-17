<?php
/**
 * 后台角色处理
 * Date: 2018/10/4
 * Time: 16:15
 */
namespace Admin\Services\Authority\Processor;

use Common\Models\System\AdminUserRole;
use Frameworks\Services\Basic\Processor\BaseProcessor;

class AdminUserRoleProcessor extends BaseProcessor
{
    protected $tableName = 'admin_user_roles';
    protected $tableClass = AdminUserRole::class;

    public function getSingleByNo($roleNo, $columns = [])
    {
        if (empty($roleNo)) {
            return '';
        }
        $where = ['role_no' => $roleNo];
        return $this->getSingle($where, $columns);
    }

    public function getSingleByName($name, $columns = [])
    {
        if (empty($name)) {
            return '';
        }
        $where = ['name' => $name];
        return $this->getSingle($where, $columns);
    }
}