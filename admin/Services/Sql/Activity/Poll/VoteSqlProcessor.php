<?php
/**
 * 网络投票活动投票明细
 * Date: 2018/10/22
 * Time: 9:40
 */
namespace Admin\Services\Sql\Activity\Poll;

use Frameworks\Services\Basic\Processor\BaseSqlProcessor;
use Common\Config\ActivityConfig;
use Admin\Services\Sql\BaseSqlDelegation;

class VoteSqlProcessor extends BaseSqlProcessor implements BaseSqlDelegation
{
    public function getListSql($model, $params, $url, $options = [])
    {
        $urlParams = ['search'=>'search'];
        $model = $model->whereHas('activity', function ($query) {
            $query->where('type', ActivityConfig::POLL_TYPE);
        });
        // 类别
        $type = intval(trim(array_get($params, 'type')));
        if ($type > 0) {
            $typeValue = $type - 1;
            $model = $model->where('type', $typeValue);
            $urlParams['type'] = $type;
        }
        // 活动ID
        $activityId = intval(trim(array_get($params, 'activity_id')));
        if ($activityId > 0) {
            $model = $model->where('activity_id', $activityId);
            $urlParams['activity_id'] = $activityId;
        }
        // 用户ID
        $userId = intval(trim(array_get($params, 'user_id')));
        if ($userId > 0) {
            $model = $model->where('user_id', $userId);
            $urlParams['user_id'] = $userId;
        }
        // 问题ID
        $questionId = intval(trim(array_get($params, 'question_id')));
        if ($questionId > 0) {
            $model = $model->where('question_id', $questionId);
            $urlParams['question_id'] = $questionId;
        }
        // 开始时间
        $fromTime = trim(array_get($params, 'from_time'));
        if (!empty($fromTime)) {
            $model = $model->where('created_at', '>=', $fromTime);
            $urlParams['from_time'] = $fromTime;
        }
        // 结束时间
        $endTime = trim(array_get($params, 'end_time'));
        if (!empty($endTime)) {
            $model = $model->where('created_at', '<=', $endTime);
            $urlParams['end_time'] = $endTime;
        }
        $model->orderBy('created_at', 'DESC');
        $url .= '?'.implode('&', $urlParams);
        return [$model, $urlParams, $url];
    }
}
