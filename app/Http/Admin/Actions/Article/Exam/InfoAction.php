<?php
/**
 * 中高考政策
 * Date: 2018/10/8
 * Time: 22:43
 */
namespace App\Http\Admin\Actions\Article\Exam;

use Admin\Models\Article\Article;
use App\Http\Admin\Actions\Article\BaseInfoAction;
use Frameworks\Tool\Http\HttpConfig;

class InfoAction extends BaseInfoAction
{
    protected $_type = 2;
    protected $_typeName = '中高考政策';

    public function run()
    {
        $httpTool = $this->getHttpTool();
        $id = $httpTool->getBothSafeParam('id', HttpConfig::PARAM_NUMBER_TYPE);
        $workNo = $httpTool->getBothSafeParam('work_no', HttpConfig::PARAM_NUMBER_TYPE);
        if (!empty($id)) {
            $this->_article = Article::find($id);
        }
        if ($workNo == 1 || $workNo == 2) {
            if ($workNo == 1) {
                return $this->showInfo();
            } else {
                $this->process();
            }
        }
        $this->errorJson(500, '请求类型不匹配');
    }

    protected function showInfo()
    {
        $result = [
            'record'            =>  $this->_article,
            'articleType'       =>  1,
            'menu'              =>  ['articleCenter', 'examManage', 'articleExamInfo'],
            'actionUrl'         => route('articleExamInfo', ['work_no'=>2]),
        ];
        return $this->createView('admin.article.exam.info', $result);
    }
}
