<?php
/**
 * 用户意见
 * Date: 2018/10/22
 * Time: 4:09
 */
namespace Admin\Services\User\Processor;

use Common\Models\User\UserAdmonition;
use Frameworks\Services\Basic\Processor\BaseProcessor;

class UserAdmonitionProcessor extends BaseProcessor
{
    protected $tableName = 'user_admonitions';
    protected $tableClass = UserAdmonition::class;
}
