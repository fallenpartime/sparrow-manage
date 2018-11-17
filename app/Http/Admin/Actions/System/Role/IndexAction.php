<?php
/**
 * 角色列表
 * Date: 2018/10/4
 * Time: 16:07
 */
namespace App\Http\Admin\Actions\System\Role;

use Admin\Actions\BaseAction;
use Admin\Config\AdminConfig;
use Admin\Models\System\AdminUserRole;

class IndexAction extends BaseAction
{

    public function run()
    {
        $list = AdminUserRole::with('accesses')->get();
        $result = [
            'list'  =>  $this->processList($list),
            'menu'  =>  ['manageCenter', 'roleManage', 'roles']
        ];
        return $this->createView('admin.system.role.index', $result);
    }

    protected function processList($list)
    {
        $outList = [];
        $groupList = [];
        if (!empty($list)) {
            foreach ($list as $key => $item) {
                $unit = [
                    'no'        =>  $item->role_no,
                    'name'      =>  $item->name,
                    'actions'   =>  $item->actions,
                    'indexTag'  =>  AdminConfig::getIndexUrl($item->index_action, 'title'),
                    'group_desc'    =>  [],
                    'group_ext'     =>  [],
                    'created_at'    =>  $item->created_at,
                    'edit_url'      =>  route('roleInfo', ['work_no'=>1, 'id'=>$item->id]),
                ];
                $accesses = array_get($item, 'accesses');
                if (!empty($accesses)) {
                    foreach ($accesses as $access) {
                        $groupNo = $access->group_no;
                        if (array_key_exists($groupNo, $groupList)) {
                            $group = $groupList[$groupNo];
                        } else {
                            $group = array_get($access, 'group');
                            if (empty($group)) {
                                continue;
                            }
                        }
                        $groupName  = $group->name;
//                        $leaderStatus   = !empty($access->is_leader)? '是': '否';
//                        $unit['group_desc'][] = "分组:{$groupName},是否组长:{$leaderStatus}";
                        $unit['group_desc'][] = "分组:{$groupName}";
//                        $groupExtList = !empty($group->actions)? json_decode($group->actions, true): [];
//                        if (!empty($groupExtList)) {
//                            $unit['group_ext'] = array_merge($unit['group_ext'], $groupExtList);
//                        }
                    }
                }
                $unit['group_desc'] = implode('<br>', $unit['group_desc']);
//                $unit['group_ext'] = array_unique($unit['group_ext']);
                $outList[] = $unit;
            }
        }
        return $outList;
    }
}