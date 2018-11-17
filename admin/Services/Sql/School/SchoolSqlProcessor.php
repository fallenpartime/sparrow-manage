<?php
/**
 * 学校
 * Date: 2018/10/7
 * Time: 20:05
 */
namespace Admin\Services\Sql\School;

use Frameworks\Services\Basic\Processor\BaseSqlProcessor;
use Admin\Services\Sql\BaseSqlDelegation;

class SchoolSqlProcessor extends BaseSqlProcessor implements BaseSqlDelegation
{
    public function getListSql($model, $params, $url, $options = [])
    {
        $urlParams = ['search'=>'search'];
        // 学校编号
        $no = trim(array_get($params, 'no'));
        if (!empty($no)) {
            $model = $model->where('no', $no);
            $urlParams['no'] = $no;
        }
        // 学校名称
        $name = trim(array_get($params, 'name'));
        if (!empty($name)) {
            $model = $model->where('name', $name);
            $urlParams['name'] = $name;
        }
        // 学区
        $districtNo = trim(array_get($params, 'district_no'));
        if (!empty($districtNo)) {
            $model = $model->where('district_no', $districtNo);
            $urlParams['district_no'] = $districtNo;
        }
        // 学校性质
        $property = trim(array_get($params, 'property'));
        if ($property != '') {
            $model = $model->where('property', $property);
            $urlParams['property'] = $property;
        }
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
        $model->orderBy('created_at', 'DESC');
        $url .= '?'.implode('&', $urlParams);
        return [$model, $urlParams, $url];
    }
}
