<?php
/**
 * 文章服务
 * Date: 2018/10/29
 * Time: 9:30
 */
namespace Admin\Services\Article;

use Common\Config\ArticleConfig;
use Common\Models\Article\Article;
use Frameworks\Tool\Random\HashTool;
use Frameworks\Traits\DefaultCacheTrait;
use Illuminate\Support\Facades\Redis;

class ArticleService
{
    use DefaultCacheTrait;

    protected $id = 0;
    protected $hashTool = null;

    public function __construct($id = 0)
    {
        $this->id = $id;
    }

    public function _init($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getHashTool()
    {
        if (empty($this->hashTool)) {
            $this->hashTool = new HashTool();
        }
        return $this->hashTool;
    }

    /**
     * 获取缓存关键字
     * @param $id
     * @return string
     */
    public function cacheKeyword($id)
    {
        return ArticleConfig::getCacheKeyword($id);
    }

    /**
     * 获取文章缓存记录
     * @param int $id
     * @return array
     */
    public function getCacheRecord($id = 0)
    {
        if (empty($id)) {
            $id = intval($this->id);
        }
        if ($id <= 0) {
            return [];
        }
        $cacheKeyword = $this->cacheKeyword($id);
        return $this->getRedis()->hgetall($cacheKeyword);
    }

    /**
     * 设置文章缓存信息
     * @param $data
     * @return array
     */
    public function setCacheRecord($data)
    {
        $id = intval($this->id);
        if ($id <= 0) {
            return false;
        }
        $cacheKeyword = $this->cacheKeyword($id);
        return $this->getRedis()->hmset($cacheKeyword, $data);
    }

    /**
     * 文章缓存作废
     * @return array
     */
    public function removeCacheRecord()
    {
        $id = intval($this->id);
        if ($id <= 0) {
            return false;
        }
        $cacheKeyword = $this->cacheKeyword($id);
        return $this->getRedis()->remove($cacheKeyword);
    }

    /**
     * 阅读计数器
     */
    public function readCounter()
    {
        $id = intval($this->id);
        if ($id <= 0) {
            return false;
        }
        $result = Article::find($id)->increment('read_count');
        if ($result) {
            $cacheKeyword = $this->cacheKeyword($id);
            $this->getRedis()->hincrby($cacheKeyword, 'read_count', 1);
        }
        return true;
    }

    /**
     * 点赞计数器
     */
    public function likeCounter()
    {
        $id = intval($this->id);
        if ($id <= 0) {
            return false;
        }
        $cacheKeyword = $this->cacheKeyword($id);
        return $this->getRedis()->hincrby($cacheKeyword, 'like_count', 1);
    }

    public function getRecord($id = 0, $isPreview = false)
    {
        if (empty($id)) {
            $id = intval($this->id);
        }
        if ($id <= 0) {
            return [];
        }
        if ($isPreview) {
            $record = Article::find($id);
            return !empty($record)? $record: [];
        }
        $record = $this->getCacheRecord($id);
        if (empty($record)) {
            $record = Article::find($id);
            if ($record && $record->is_show == 0) {
                return [];
            }
        } else if(array_get($record, 'is_show') == 0) {
            return [];
        }
        return !empty($record)? $record: [];
    }

    /**
     * 生成对外显示地址
     * @param $type
     * @return string
     */
    public function getShowUrl($type)
    {
        $code = $this->getHashTool()->encode($this->id, $type);
        $routeName = '';
        switch ($type) {
            case 1:
                $routeName = 'front.news.info';
                break;
            case 2:
                $routeName = 'front.exam.info';
                break;
            case 3:
                $routeName = 'front.practice.info';
                break;
            case 4:
                $routeName = 'front.teching.info';
                break;
            default:
                ;
        }
        if (!empty($routeName)) {
            return route($routeName, ['code'=>$code]);
        }
        return '';
    }

    /**
     * 生成对外显示预览地址
     * @param $type
     * @return string
     */
    public function getPreviewShowUrl($type)
    {
        $hashTool = $this->getHashTool();
        $code = $hashTool->encode($this->id, $type);
        $timeOutCode = $hashTool->encode(time() + 60);
        $routeName = '';
        switch ($type) {
            case 1:
                $routeName = 'front.news.info';
                break;
            case 2:
                $routeName = 'front.exam.info';
                break;
            case 3:
                $routeName = 'front.practice.info';
                break;
            case 4:
                $routeName = 'front.teching.info';
                break;
            default:
                ;
        }
        if (!empty($routeName)) {
            return route($routeName, ['code'=>$code, 'precode'=>$timeOutCode]);
        }
        return '';
    }

    public function getCode($id, $type)
    {
        return $this->getHashTool()->encode($id, $type);
    }
}
