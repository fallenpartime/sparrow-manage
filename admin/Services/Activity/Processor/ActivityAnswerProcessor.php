<?php
/**
 * 活动问题答案处理单元
 * Date: 2018/10/16
 * Time: 14:59
 */
namespace Admin\Services\Activity\Processor;

use Common\Models\Activity\ActivityAnswer;
use Frameworks\Services\Basic\Processor\BaseProcessor;

class ActivityAnswerProcessor extends BaseProcessor
{
    protected $tableName = 'activity_answers';
    protected $tableClass = ActivityAnswer::class;
}
