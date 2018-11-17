<?php
/**
 * 活动配置
 * Date: 2018/10/8
 * Time: 2:41
 */
namespace Common\Config;

class ActivityConfig
{
    const POLL_TYPE = 1;
    const CACHE_PREFIX = 'edu:activity:';
    const VOTE_PREFIX = 'edu:activity:vote:';

    /**
     * 活动类型
     * @return array
     */
    public static function getTypeList()
    {
        return [
            static::POLL_TYPE       =>  ['type' =>  static::POLL_TYPE, 'title'  =>  '网络投票活动'],
        ];
    }

    /**
     * 文章缓存关键字
     * @param $id
     * @return string
     */
    public static function getCacheKeyword($id)
    {
        return self::CACHE_PREFIX.$id;
    }
}
