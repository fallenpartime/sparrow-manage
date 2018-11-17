<?php
/**
 * 网络投票活动问题列表
 * Date: 2018/10/20
 * Time: 23:39
 */
namespace Admin\Services\Sql\Activity\Poll;

use Frameworks\Services\Basic\Processor\BaseSqlProcessor;
use Admin\Services\Sql\BaseSqlDelegation;

class QuestionSqlProcessor extends BaseSqlProcessor implements BaseSqlDelegation
{
    public function getListSql($model, $params, $url, $options = [])
    {
        $urlParams = ['search'=>'search'];
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
        // 显示状态
        $isShow = intval(trim(array_get($params, 'is_show')));
        if ($isShow > 0) {
            $showValue = $isShow == 1? 1: 0;
            $model = $model->where('is_show', $showValue);
            $urlParams['is_show'] = $isShow;
        }
        // 是否多选
        $isCheckbox = intval(trim(array_get($params, 'is_checkbox')));
        if ($isCheckbox > 0) {
            $checkValue = $isCheckbox == 1? 1: 0;
            $model = $model->where('is_checkbox', $checkValue);
            $urlParams['is_checkbox'] = $isCheckbox;
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