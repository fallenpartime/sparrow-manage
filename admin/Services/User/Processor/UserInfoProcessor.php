<?php
/**
 * 用户其他信息处理
 * Date: 2018/11/19
 * Time: 14:29
 */
namespace Admin\Services\User\Processor;

use Common\Models\User\UserInfo;
use Frameworks\Services\Basic\Processor\BaseProcessor;

class UserInfoProcessor extends BaseProcessor
{
    protected $tableName = 'user_infos';
    protected $tableClass = UserInfo::class;
}