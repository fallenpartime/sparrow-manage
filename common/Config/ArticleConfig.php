<?php
/**
 * 文章配置
 * Date: 2018/10/8
 * Time: 2:41
 */
namespace Common\Config;

class ArticleConfig
{
    const NEWS_TYPE = 1;
    const EXAM_TYPE = 2;
    const PRACTICE_TYPE = 3;
    const TECH_TYPE = 4;
    const CACHE_PREFIX = 'edu:article:';

    /**
     * 文章类别
     * @return array
     */
    public static function getTypeList()
    {
        return [
            static::NEWS_TYPE       =>  ['type' =>  static::NEWS_TYPE, 'title'  =>  '教育新闻'],
            static::EXAM_TYPE       =>  ['type' =>  static::EXAM_TYPE, 'title'  =>  '中高考政策'],
            static::PRACTICE_TYPE   =>  ['type' =>  static::PRACTICE_TYPE, 'title'  =>  '社会实践记录'],
            static::TECH_TYPE       =>  ['type' =>  static::TECH_TYPE, 'title'  =>  '教研活动'],
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
