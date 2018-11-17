<?php
/**
 * 后台管理菜单配置
 * Date: 2018/10/3
 * Time: 20:47
 */
namespace Admin\Config;

class AdminMenuConfig
{

    public static function menuList()
    {
        return [
            'articleCenter'  =>  [
                'newsManage'  =>  '',
                'examManage'  =>  '',
                'practiceManage'    =>  '',
                'techingManage'     =>  '',
            ],
            'activityCenter'  =>  [
                'pollManage'  =>  '',
            ],
            'interactCenter'  =>  [
                'admonitionManage'  =>  '',
            ],
            'schoolCenter'  =>  [
                'schoolDistrictManage'  =>  '',
                'schoolManage'          =>  '',
            ],
            'manageCenter'  =>  [
                'ownerManage'       =>  '',
                'groupManage'       =>  '',
                'roleManage'        =>  '',
                'authorityManage'   =>  '',
                'logManage'         =>  '',
            ],
        ];
    }

    public static function children()
    {
        return [
            'articleCenter' =>  [
                'newsManage'    =>  [
                    'news'              =>  route('news'),
                    'articleNewsInfo'   =>  route('articleNewsInfo', ['work_no'=>1]),
                ],
                'examManage'    =>  [
                    'exams'             =>  route('exams'),
                    'articleExamInfo'   =>  route('articleExamInfo', ['work_no'=>1]),
                ],
                'practiceManage'    =>  [
                    'practices'             =>  route('practices'),
                    'articlePracticeInfo'   =>  route('articlePracticeInfo', ['work_no'=>1]),
                ],
                'techingManage'     =>  [
                    'techings'              =>  route('techings'),
                    'articleTechingInfo'    =>  route('articleTechingInfo', ['work_no'=>1]),
                ],
            ],
            'activityCenter'  =>  [
                'pollManage'  =>  [
                    'polls'                 =>  route('polls'),
                    'activityPollInfo'      =>  route('activityPollInfo', ['work_no'=>1]),
                    'activityPollQuestions'     =>  route('activityPollQuestions'),
                    'activityPollQuestionInfo'  =>  route('activityPollQuestionInfo', ['work_no'=>1]),
                ],
            ],
            'interactCenter'  =>  [
                'admonitionManage'      =>  [
                    'admonitions'       =>  route('admonitions'),
                ],
            ],
            'schoolCenter'  =>  [
                'schoolDistrictManage'  =>  [
                    'districts'     =>  route('districts'),
                    'districtInfo'  =>  route('districtInfo', ['work_no'=>1])
                ],
                'schoolManage'          =>  [
                    'schools'     =>  route('schools'),
                    'schoolInfo'  =>  route('schoolInfo', ['work_no'=>1])
                ],
            ],
            'manageCenter'  =>  [
                'ownerManage'   =>  [
                    'owners'            =>  route('owners'),
                    'ownerInfo'         =>  route('ownerInfo', ['work_no'=>1])
                ],
                'groupManage'   =>  [
                    'groups'            =>  route('groups'),
                    'groupInfo'         =>  route('groupInfo', ['work_no'=>1])
                ],
                'roleManage'   =>  [
                    'roles'             =>  route('roles'),
                    'roleInfo'          =>  route('roleInfo', ['work_no'=>1])
                ],
                'authorityManage'   =>  [
                    'authorities'       =>  route('authorities'),
                    'authorityInfo'     =>  route('authorityInfo', ['work_no'=>1])
                ],
                'logManage'     =>  [
                    'operateLogs'       =>  route('operateLogs'),
                    'adminLogs'         =>  route('adminLogs')
                ],
            ],
        ];
    }
}