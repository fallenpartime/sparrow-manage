<?php
/**
 * 权限列表
 * Date: 2018/10/3
 * Time: 20:05
 */
namespace App\Http\Admin\Actions\System\Authority;

use Admin\Actions\BaseAction;
use Admin\Services\Authority\AuthorityService;

class IndexAction extends BaseAction
{
    public function run()
    {
        $service = new AuthorityService();
        $list = $service->relateMenu([1,2,3], 1);
        $result = [
            'list'  =>  $list,
            'menu'  =>  ['manageCenter', 'authorityManage', 'authorities']
        ];
        return $this->createView('admin.system.authority.index', $result);
    }
}