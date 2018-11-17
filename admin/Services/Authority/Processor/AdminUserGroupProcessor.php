<?php
/**
 * 后台分组处理
 * Date: 2018/10/4
 * Time: 16:15
 */
namespace Admin\Services\Authority\Processor;

use Common\Models\System\AdminUserGroup;
use Frameworks\Services\Basic\Processor\BaseProcessor;

class AdminUserGroupProcessor extends BaseProcessor
{
    protected $tableName = 'admin_user_groups';
    protected $tableClass = AdminUserGroup::class;

    public function getSingleByNo($groupNo, $columns = [])
    {
        if (empty($groupNo)) {
            return '';
        }
        $where = ['group_no' => $groupNo];
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

    public function getSingleByTip($tip, $columns = [])
    {
        if (empty($tip)) {
            return '';
        }
        $where = ['tip' => $tip];
        return $this->getSingle($where, $columns);
    }
}