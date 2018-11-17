<?php
/**
 * 活动问题处理单元
 * Date: 2018/10/16
 * Time: 14:59
 */
namespace Admin\Services\Activity\Processor;

use Common\Models\Activity\ActivityQuestion;
use Frameworks\Services\Basic\Processor\BaseProcessor;

class ActivityQuestionProcessor extends BaseProcessor
{
    protected $tableName = 'activity_questions';
    protected $tableClass = ActivityQuestion::class;
}
