<?php
/**
 * 后台权限处理
 * Date: 2018/10/4
 * Time: 0:35
 */
namespace Admin\Services\Authority\Processor;

use Common\Models\System\AdminAction;
use Frameworks\Services\Basic\Processor\BaseProcessor;

class AdminActionProcessor extends BaseProcessor
{
    protected $tableName = "admin_actions";
    protected $tableClass = AdminAction::class;

    public function getSingleByName($name, $columns = [])
    {
        if (empty($name)) {
            return '';
        }
        $where = ['name' => $name];
        return $this->getSingle($where, $columns);
    }

    public function getSingleByAction($action, $columns = [])
    {
        if (empty($action)) {
            return '';
        }
        $where = ['ts_action' => $action];
        return $this->getSingle($where, $columns);
    }
}