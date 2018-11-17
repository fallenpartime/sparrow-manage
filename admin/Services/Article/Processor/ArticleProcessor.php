<?php
/**
 * 文章
 * Date: 2018/10/4
 * Time: 16:15
 */
namespace Admin\Services\Article\Processor;

use Common\Models\Article\Article;
use Frameworks\Services\Basic\Processor\BaseProcessor;

class ArticleProcessor extends BaseProcessor
{
    protected $tableName = 'articles';
    protected $tableClass = Article::class;
}