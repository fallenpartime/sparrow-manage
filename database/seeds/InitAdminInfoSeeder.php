<?php

use Illuminate\Database\Seeder;

use Admin\Services\Authority\Processor\AdminUserProcessor;
use Admin\Services\Authority\Processor\AdminUserInfoProcessor;
use Admin\Services\Authority\Processor\AdminUserGroupProcessor;
use Admin\Services\Authority\Processor\AdminUserRoleProcessor;
use Admin\Services\Authority\Processor\AdminUserRoleAccessProcessor;
use Admin\Services\Authority\Processor\AdminActionProcessor;

class InitAdminInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 分组信息
        $groupProcessor = new AdminUserGroupProcessor();
        list($status, $group) = $groupProcessor->insert(['group_no'=>1, 'name'=>'管理员', 'tip'=>'administrator']);
        // 角色信息
        $roleProcessor = new AdminUserRoleProcessor();
        list($status, $role) = $roleProcessor->insert(['role_no'=>1, 'name'=>'管理员', 'index_action'=>'owners']);
        // 角色关联信息
        $accessProcessor = new AdminUserRoleAccessProcessor();
        list($status, $access) = $accessProcessor->insert(['group_no'=>$group->group_no, 'role_no'=>$role->role_no]);
        // 用户信息
        $userProcessor = new AdminUserProcessor();
        list($status, $user) = $userProcessor->insert(['name'=>'adminc', 'phone'=>'13212345678', 'pwd'=>'65c21e07a6b79fe43e624e0e853d94dd', 'salt'=>'61d17b104905d7474c4f917627ba7fab']);
        // 用户详情信息
        $userInfoProcessor = new AdminUserInfoProcessor();
        list($status, $userInfo) = $userInfoProcessor->insert(['user_id'=>$user->id, 'role_id'=>$role->role_no, 'is_admin'=>1]);
        $this->initActionList();
    }

    protected function initActionList()
    {
        $list = [
            ['name'=>'首页', 'type'=>1, 'action'=>'index', 'list'=>[]],
            ['name'=>'学校管理中心', 'type'=>1, 'action'=>'schoolCenter', 'list'=>[
                ['name'=>'学区管理', 'type'=>2, 'action'=>'schoolDistrictManage', 'list'=>[
                    ['name'=>'学区列表', 'type'=>3, 'action'=>'districts'],
                    ['name'=>'学区配置', 'type'=>3, 'action'=>'districtInfo'],
                    ['name'=>'学区显示状态修改', 'type'=>3, 'action'=>'districtShow']
                ]],
                ['name'=>'学校管理', 'type'=>2, 'action'=>'schoolManage', 'list'=>[
                    ['name'=>'学校列表', 'type'=>3, 'action'=>'schools'],
                    ['name'=>'学校配置', 'type'=>3, 'action'=>'schoolInfo'],
                    ['name'=>'学校显示状态修改', 'type'=>3, 'action'=>'schoolShow']
                ]],
            ]],
            ['name'=>'文章管理中心', 'type'=>1, 'action'=>'articleCenter', 'list'=>[
                ['name'=>'文章操作', 'type'=>2, 'action'=>'operateArticle', 'list'=>[
                    ['name'=>'文章显示状态修改', 'type'=>3, 'action'=>'articleShow'],
                    ['name'=>'文章作废', 'type'=>3, 'action'=>'articleRemove']
                ]],
                ['name'=>'教育资讯管理', 'type'=>2, 'action'=>'newsManage', 'list'=>[
                    ['name'=>'教育资讯列表', 'type'=>3, 'action'=>'news'],
                    ['name'=>'教育资讯配置', 'type'=>3, 'action'=>'articleNewsInfo'],
                ]],
                ['name'=>'中高考政策管理', 'type'=>2, 'action'=>'examManage', 'list'=>[
                    ['name'=>'中高考政策列表', 'type'=>3, 'action'=>'exams'],
                    ['name'=>'中高考政策配置', 'type'=>3, 'action'=>'articleExamInfo'],
                ]],
                ['name'=>'社会实践记录管理', 'type'=>2, 'action'=>'practiceManage', 'list'=>[
                    ['name'=>'社会实践记录列表', 'type'=>3, 'action'=>'practices'],
                    ['name'=>'社会实践记录配置', 'type'=>3, 'action'=>'articlePracticeInfo'],
                ]],
                ['name'=>'教研活动管理', 'type'=>2, 'action'=>'techingManage', 'list'=>[
                    ['name'=>'教研活动列表', 'type'=>3, 'action'=>'techings'],
                    ['name'=>'教研活动配置', 'type'=>3, 'action'=>'articleTechingInfo'],
                ]],
            ]],
            ['name'=>'活动管理中心', 'type'=>1, 'action'=>'activityCenter', 'list'=>[
                ['name'=>'活动操作', 'type'=>2, 'action'=>'operateActivity', 'list'=>[
                    ['name'=>'活动显示状态修改', 'type'=>3, 'action'=>'activityShow'],
                    ['name'=>'活动作废', 'type'=>3, 'action'=>'activityRemove'],
                    ['name'=>'活动开启状态修改', 'type'=>3, 'action'=>'activityOpen'],
                ]],
                ['name'=>'网络投票管理', 'type'=>2, 'action'=>'pollManage', 'list'=>[
                    ['name'=>'网络投票列表', 'type'=>3, 'action'=>'polls'],
                    ['name'=>'网络投票配置', 'type'=>3, 'action'=>'activityPollInfo'],
                    ['name'=>'网络投票问题列表', 'type'=>3, 'action'=>'activityPollQuestions'],
                    ['name'=>'网络投票问题配置', 'type'=>3, 'action'=>'activityPollQuestionInfo'],
                ]],
            ]],
        ];
        $actionProcessor = new AdminActionProcessor();
        foreach ($list as $top) {
            $topName = $top['name'];
            $topAction = $top['action'];
            $secondList = $top['list'];
            list($status, $action) = $actionProcessor->insert(['name'=>$topName, 'type'=>1, 'ts_action'=>$topAction]);
            if (!empty($secondList)) {
                $topId = $action->id;
                foreach ($secondList as $second) {
                    $secondName = $second['name'];
                    $secondAction = $second['action'];
                    $operateList = $second['list'];
                    list($status, $action) = $actionProcessor->insert(['name'=>$secondName, 'type'=>2, 'ts_action'=>$secondAction, 'parent_id'=>$topId]);
                    if (!empty($operateList)) {
                        $secondId = $action->id;
                        foreach ($operateList as $operate) {
                            $operateName = $operate['name'];
                            $operateAction = $operate['action'];
                            list($status, $action) = $actionProcessor->insert(['name'=>$operateName, 'type'=>3, 'ts_action'=>$operateAction, 'parent_id'=>$secondId]);
                        }
                    }
                }
            }
        }
    }
}
