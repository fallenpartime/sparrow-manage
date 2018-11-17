<?php
/**
 * 分组列表
 * Date: 2018/10/4
 * Time: 9:17
 */
namespace App\Http\Admin\Actions\System\Group;

use Admin\Actions\BaseAction;
use Admin\Models\System\AdminUserGroup;

class IndexAction extends BaseAction
{
    public function run()
    {
        $list = AdminUserGroup::all();
        $result = [
            'list'  =>  $list,
            'menu'  =>  ['manageCenter', 'groupManage', 'groups']
        ];
        return $this->createView('admin.system.group.index', $result);
    }
}