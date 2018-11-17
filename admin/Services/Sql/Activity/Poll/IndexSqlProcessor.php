<?php
/**
 * 网络投票活动列表
 * Date: 2018/10/20
 * Time: 23:39
 */
namespace Admin\Services\Sql\Activity\Poll;

use Frameworks\Services\Basic\Processor\BaseSqlProcessor;
use Common\Config\ActivityConfig;
use Admin\Services\Sql\BaseSqlDelegation;

class IndexSqlProcessor extends BaseSqlProcessor implements BaseSqlDelegation
{
    public function getListSql($model, $params, $url, $options = [])
    {
        $urlParams = ['search'=>'search'];
        $model = $model->where('type', ActivityConfig::POLL_TYPE);
        // 显示状态
        $isShow = intval(trim(array_get($params, 'is_show')));
        if ($isShow > 0) {
            $showValue = $isShow == 1? 1: 0;
            $model = $model->where('is_show', $showValue);
            $urlParams['is_show'] = $isShow;
        }
        // 开启状态
        $openStatus = intval(trim(array_get($params, 'open_status')));
        if ($openStatus > 0) {
            switch ($openStatus) {
                case 1:
                    $model = $model->where('is_open', 0);
                    break;
                case 2:
                    {
                        $model = $model->where('is_open', 1);
                        $model = $model->whereNotNull('opened_at');
                        $model = $model->whereNull('overed_at');
                    }
                    break;
                case 3:
                    {
                        $model = $model->where('is_open', 1);
                        $model = $model->whereNotNull('overed_at');
                    }
                    break;
                default:
                    ;
            }
            $urlParams['open_status'] = $openStatus;
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
        // 发布时间-开始时间
        $fromTime = trim(array_get($params, 'from_publish_time'));
        if (!empty($fromTime)) {
            $model = $model->where('published_at', '>=', $fromTime);
            $urlParams['from_publish_time'] = $fromTime;
        }
        // 发布时间-结束时间
        $endTime = trim(array_get($params, 'end_publish_time'));
        if (!empty($endTime)) {
            $model = $model->where('published_at', '<=', $endTime);
            $urlParams['end_publish_time'] = $endTime;
        }
        // 开启时间-开始时间
        $fromTime = trim(array_get($params, 'from_open_time'));
        if (!empty($fromTime)) {
            $model = $model->where('opened_at', '>=', $fromTime);
            $urlParams['from_open_time'] = $fromTime;
        }
        // 开启时间-结束时间
        $endTime = trim(array_get($params, 'end_open_time'));
        if (!empty($endTime)) {
            $model = $model->where('opened_at', '<=', $endTime);
            $urlParams['end_open_time'] = $endTime;
        }
        $model->orderBy('created_at', 'DESC');
        $url .= '?'.implode('&', $urlParams);
        return [$model, $urlParams, $url];
    }
}