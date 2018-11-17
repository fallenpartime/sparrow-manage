<?php
/**
 * 后台权限处理
 * Date: 2018/10/4
 * Time: 0:35
 */
namespace Admin\Services\Authority\Processor;

use Common\Models\System\AdminUserAction;
use Frameworks\Services\Basic\Processor\BaseProcessor;

class AdminUserActionProcessor extends BaseProcessor
{
    protected $tableName = "admin_user_actions";
    protected $tableClass = AdminUserAction::class;

    public function getSingleByUserId($userId, $columns = [])
    {
        if (empty($userId)) {
            return '';
        }
        $where = ['user_id' => $userId];
        return $this->getSingle($where, $columns);
    }
}
