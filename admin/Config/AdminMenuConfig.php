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
                    'articleNewsInfo'   =>  route('articleNewsInfo'),
                ],
                'examManage'    =>  [
                    'exams'             =>  route('exams'),
                    'articleExamInfo'   =>  route('articleExamInfo'),
                ],
                'practiceManage'    =>  [
                    'practices'             =>  route('practices'),
                    'articlePracticeInfo'   =>  route('articlePracticeInfo'),
                ],
                'techingManage'     =>  [
                    'techings'              =>  route('techings'),
                    'articleTechingInfo'    =>  route('articleTechingInfo'),
                ],
            ],
            'activityCenter'  =>  [
                'pollManage'  =>  [
                    'polls'                 =>  route('polls'),
                    'activityPollInfo'      =>  route('activityPollInfo'),
                    'activityPollQuestions'     =>  route('activityPollQuestions'),
                    'activityPollQuestionInfo'  =>  route('activityPollQuestionInfo'),
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
                    'districtInfo'  =>  route('districtInfo')
                ],
                'schoolManage'          =>  [
                    'schools'     =>  route('schools'),
                    'schoolInfo'  =>  route('schoolInfo')
                ],
            ],
            'manageCenter'  =>  [
                'ownerManage'   =>  [
                    'owners'            =>  route('owners'),
                    'ownerInfo'         =>  route('ownerInfo')
                ],
                'groupManage'   =>  [
                    'groups'            =>  route('groups'),
                    'groupInfo'         =>  route('groupInfo')
                ],
                'roleManage'   =>  [
                    'roles'             =>  route('roles'),
                    'roleInfo'          =>  route('roleInfo')
                ],
                'authorityManage'   =>  [
                    'authorities'       =>  route('authorities'),
                    'authorityInfo'     =>  route('authorityInfo')
                ],
                'logManage'     =>  [
                    'operateLogs'       =>  route('operateLogs'),
                    'adminLogs'         =>  route('adminLogs')
                ],
            ],
        ];
    }
}