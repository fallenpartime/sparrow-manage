<?php
/**
 * 学校配置
 * Date: 2018/10/23
 * Time: 16:32
 */
namespace Common\Config;

class SchoolConfig
{
    /**
     * 学校属性
     * @return array
     */
    public static function getPropertyList()
    {
        return [
            '0' =>  ['type' => 0, 'title' => '未知'],
            '1' =>  ['type' => 1, 'title' => '公立'],
            '2' =>  ['type' => 2, 'title' => '私立'],
        ];
    }
}
