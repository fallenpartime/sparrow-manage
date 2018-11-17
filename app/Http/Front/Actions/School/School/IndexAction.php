<?php
/**
 * 教育机构
 * Date: 2018/10/31
 * Time: 22:59
 */
namespace App\Http\Front\Actions\School\School;

use Admin\Models\School\School;
use Admin\Traits\ApiActionTrait;
use Front\Actions\BaseAction;

class IndexAction extends BaseAction
{
    use ApiActionTrait;

    public function run()
    {
        if (!$this->request->isMethod('post')) {
            return view('front.school.school.index', ['check_url'=>route('front.school.search')]);
        }
        $httpTool = $this->getHttpTool();
        $keyword = $httpTool->getBothSafeParam('keyword');
        $list = $this->getList($keyword);
        if (!empty($list)) {
            foreach ($list as $key => $item) {
                switch ($list[$key]->property) {
                    case 0:
                        $list[$key]->property = '未知';
                        break;
                    case 1:
                        $list[$key]->property = '公立';
                        break;
                    case 2:
                        $list[$key]->property = '私立';
                        break;
                }
            }
        }
        $this->getJsonTool()->customJson(['code'=>1, 'result'=>$list]);
    }

    protected function getList($keyword)
    {
        $keyword = trim($keyword);
        if (!empty($keyword)) {
            return School::where('name', 'like', "%{$keyword}%")->where('is_show', 1)->select(['name', 'address', 'telent', 'property'])->get();
        }
        return [];
    }
}