<?php
/**
 * 后台用户处理
 * Date: 2018/10/4
 * Time: 16:15
 */
namespace Admin\Services\Authority\Processor;

use Common\Models\System\AdminUser;
use Frameworks\Services\Basic\Processor\BaseProcessor;

class AdminUserProcessor extends BaseProcessor
{
    protected $tableName = 'admin_users';
    protected $tableClass = AdminUser::class;

    public function getSingleByName($name, $columns = [])
    {
        if (empty($name)) {
            return '';
        }
        $where = ['name' => $name];
        return $this->getSingle($where, $columns);
    }

    public function getSingleByPhone($phone, $columns = [])
    {
        if (empty($phone)) {
            return '';
        }
        $where = ['phone' => $phone];
        return $this->getSingle($where, $columns);
    }
}