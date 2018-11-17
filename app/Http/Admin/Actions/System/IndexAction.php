<?php
/**
 * 入口
 * Date: 2018/10/7
 * Time: 18:16
 */
namespace App\Http\Admin\Actions\System;

use Admin\Actions\BaseAction;
use Admin\Config\AdminConfig;
use Admin\Services\Authority\Processor\AdminUserRoleProcessor;

class IndexAction extends BaseAction
{
    public function run()
    {
        $admin_info = $this->getAuthService()->getAdminInfo();
        $roleId = $admin_info['role_id'];
        $admin_url = route('admin.login');
        if ($roleId > 0) {
            $role = (new AdminUserRoleProcessor())->getSingleByNo($roleId);
            $indexAction = $role->index_action;
            if (!empty($indexAction)) {
                $admin_url = AdminConfig::getIndexUrl($indexAction, 'url', 0);
            }
        }
        header("location: {$admin_url}");
        exit;
    }
}