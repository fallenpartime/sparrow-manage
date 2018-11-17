<?php
/**
 * 社会实践记录文章列表
 * Date: 2018/10/8
 * Time: 2:19
 */
namespace Admin\Services\Sql\Article;

use Frameworks\Services\Basic\Processor\BaseSqlProcessor;
use Common\Config\ArticleConfig;
use Admin\Services\Sql\BaseSqlDelegation;

class PracticeSqlProcessor extends BaseSqlProcessor implements BaseSqlDelegation
{
    public function getListSql($model, $params, $url, $options = [])
    {
        $urlParams = ['search'=>'search'];
        $model = $model->where('type', ArticleConfig::PRACTICE_TYPE);
        // 显示状态
        $isShow = intval(trim(array_get($params, 'is_show')));
        if ($isShow > 0) {
            $showValue = $isShow == 1? 1: 0;
            $model = $model->where('is_show', $showValue);
            $urlParams['is_show'] = $isShow;
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
        $model->orderBy('created_at', 'DESC');
        $url .= '?'.implode('&', $urlParams);
        return [$model, $urlParams, $url];
    }
}
