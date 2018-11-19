<?php
/**
 * 用户信息处理
 * Date: 2018/10/23
 * Time: 10:29
 */
namespace Admin\Services\User\Processor;

use Common\Models\User\User;
use Frameworks\Services\Basic\Processor\BaseProcessor;

class UserProcessor extends BaseProcessor
{
    protected $tableName = 'users';
    protected $tableClass = User::class;

    public function getSingleByOpenId($openId, $columns = [])
    {
        if (empty($openId)) {
            return '';
        }
        $where = ['openid' => $openId];
        return $this->getSingle($where, $columns);
    }
}
