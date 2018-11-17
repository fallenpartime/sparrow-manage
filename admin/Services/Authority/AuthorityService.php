<?php
/**
 * 权限服务
 * Date: 2018/10/4
 * Time: 0:18
 */
namespace Admin\Services\Authority;

use Admin\Services\Authority\Integration\RelateAuthoritiesIntegration;

class AuthorityService
{
    /**
     * 关联权限
     * @param array $types
     * @param int $withUrl
     * @param array $columns
     * @return array|mixed
     */
    public function relateMenu($types = [1,2,3], $withUrl = 0, $columns = ['id', 'parent_id', 'type', 'name', 'ts_action'])
    {
        $integration = new RelateAuthoritiesIntegration($types, $withUrl, $columns);
        list($status, $message, $count, $list) = $integration->process();
        return !empty($status)? $list: [];
    }
}
