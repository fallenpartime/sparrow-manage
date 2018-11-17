<?php
/**
 *
 * Date: 2018/10/7
 * Time: 20:06
 */
namespace Admin\Services\Sql;

interface BaseSqlDelegation
{
    public function getListSql($model, $params, $url, $options = []);
}