<?php
/**
 * 业务操作日志
 * Date: 2018/10/23
 * Time: 13:47
 */
namespace Admin\Services\Sql\System\Log;

use Frameworks\Services\Basic\Processor\BaseSqlProcessor;
use Admin\Services\Sql\BaseSqlDelegation;

class OperateLogSqlProcessor extends BaseSqlProcessor implements BaseSqlDelegation
{
    public function getListSql($model, $params, $url, $options = [])
    {
        $urlParams = ['search'=>'search'];
        // 操作人
        $userId = intval(trim(array_get($params, 'user_id')));
        if ($userId > 0) {
            $model = $model->where('user_id', $userId);
            $urlParams['user_id'] = $userId;
        }
        // 操作类型
        $operateType = intval(trim(array_get($params, 'operate_type')));
        if ($operateType > 0) {
            $model = $model->where('operate_type', $operateType);
            $urlParams['operate_type'] = $operateType;
        }
        // 操作类型
        $objectId = intval(trim(array_get($params, 'object_id')));
        if ($objectId > 0) {
            $model = $model->where('object_id', $objectId);
            $urlParams['object_id'] = $objectId;
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
        $url .= '?'.implode('&', $urlParams);
        return [$model, $urlParams, $url];
    }
}
