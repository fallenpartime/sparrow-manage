<?php
/**
 * 中高考政策
 * Date: 2018/10/8
 * Time: 22:43
 */
namespace App\Http\Admin\Actions\Article\Exam;

use Common\Models\Article\Article;
use App\Http\Admin\Actions\Article\BaseInfoAction;
use Frameworks\Tool\Http\Config\HttpConfig;

class InfoAction extends BaseInfoAction
{
    protected $_type = 2;
    protected $_typeName = '中高考政策';

    public function run()
    {
        $httpTool = $this->getHttpTool();
        $id = $httpTool->getBothSafeParam('id', HttpConfig::PARAM_NUMBER_TYPE);
        if (!empty($id)) {
            $this->_article = Article::find($id);
        }
        if ($httpTool->isAjax()) {
            $this->process();
        }
        return $this->showInfo();
    }

    protected function showInfo()
    {
        $result = [
            'record'            =>  $this->_article,
            'articleType'       =>  1,
            'menu'              =>  ['articleCenter', 'examManage', 'articleExamInfo'],
            'actionUrl'         => route('articleExamInfo'),
        ];
        return $this->createView('admin.article.exam.info', $result);
    }
}
