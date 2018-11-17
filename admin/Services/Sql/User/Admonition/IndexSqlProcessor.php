<?php
/**
 * 意见列表
 * Date: 2018/10/23
 * Time: 10:39
 */
namespace Admin\Services\Sql\User\Admonition;

use Frameworks\Services\Basic\Processor\BaseSqlProcessor;
use Admin\Services\Sql\BaseSqlDelegation;

class IndexSqlProcessor extends BaseSqlProcessor implements BaseSqlDelegation
{
    public function getListSql($model, $params, $url, $options = [])
    {
        $urlParams = ['search'=>'search'];
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
        // 答复时间-开始时间
        $fromTime = trim(array_get($params, 'from_reply_time'));
        if (!empty($fromTime)) {
            $model = $model->where('reply_at', '>=', $fromTime);
            $urlParams['from_reply_time'] = $fromTime;
        }
        // 答复时间-结束时间
        $endTime = trim(array_get($params, 'end_reply_time'));
        if (!empty($endTime)) {
            $model = $model->where('reply_at', '<=', $endTime);
            $urlParams['end_reply_time'] = $endTime;
        }
        // 显示状态
        $isShow = intval(trim(array_get($params, 'is_show')));
        if ($isShow > 0) {
            $showValue = $isShow == 1? 1: 0;
            $model = $model->where('is_show', $showValue);
            $urlParams['is_show'] = $isShow;
        }
        // 用户名
        $name = trim(array_get($params, 'name'));
        if (!empty($name)) {
            $model = $model->where('name', $name);
            $urlParams['name'] = $name;
        }
        // 登记电话
        $phone = trim(array_get($params, 'phone'));
        if (!empty($phone)) {
            $model = $model->where('phone', $phone);
            $urlParams['phone'] = $phone;
        }
        $model->orderBy('created_at', 'DESC');
        $url .= '?'.implode('&', $urlParams);
        return [$model, $urlParams, $url];
    }
}
