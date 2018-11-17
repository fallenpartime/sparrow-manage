<?php
/**
 * 活动处理单元
 * Date: 2018/10/16
 * Time: 14:59
 */
namespace Admin\Services\Activity\Processor;

use Common\Models\Activity\Activity;
use Frameworks\Services\Basic\Processor\BaseProcessor;

class ActivityProcessor extends BaseProcessor
{
    protected $tableName = 'activities';
    protected $tableClass = Activity::class;
}
