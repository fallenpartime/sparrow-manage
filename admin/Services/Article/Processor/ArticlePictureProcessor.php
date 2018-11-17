<?php
/**
 * 文章图片
 * Date: 2018/10/4
 * Time: 16:15
 */
namespace Admin\Services\Article\Processor;

use Common\Models\Article\ArticlePicture;
use Frameworks\Services\Basic\Processor\BaseProcessor;

class ArticlePictureProcessor extends BaseProcessor
{
    protected $tableName = 'article_pictures';
    protected $tableClass = ArticlePicture::class;
}