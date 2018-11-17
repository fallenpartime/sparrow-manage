<?php
/**
 * 活动投票处理单元
 * Date: 2018/10/16
 * Time: 14:59
 */
namespace Admin\Services\Activity\Processor;

use Common\Models\Activity\ActivityVote;
use Frameworks\Services\Basic\Processor\BaseProcessor;

class ActivityVoteProcessor extends BaseProcessor
{
    protected $tableName = 'activity_votes';
    protected $tableClass = ActivityVote::class;
}
