<?php
/**
 * 后台用户信息处理
 * Date: 2018/10/4
 * Time: 16:15
 */
namespace Admin\Services\Authority\Processor;

use Common\Models\System\AdminUserInfo;
use Frameworks\Services\Basic\Processor\BaseProcessor;

class AdminUserInfoProcessor extends BaseProcessor
{
    protected $tableName = 'admin_user_infos';
    protected $tableClass = AdminUserInfo::class;

    public function getSingleByUserId($userId, $columns = [])
    {
        if (empty($userId)) {
            return '';
        }
        $where = ['user_id' => $userId];
        return $this->getSingle($where, $columns);
    }
}