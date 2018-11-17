<?php
/**
 * 学区查询
 * Date: 2018/10/31
 * Time: 23:55
 */
namespace App\Http\Front\Actions\School\District;

use Admin\Models\School\School;
use Admin\Traits\ApiActionTrait;
use Frameworks\Tool\Map\MapTool;
use Front\Actions\BaseAction;

class IndexAction extends BaseAction
{
    use ApiActionTrait;

    public function run()
    {
        $httpTool = $this->getHttpTool();
        $keyword = $httpTool->getBothSafeParam('topic');
        if (!$this->request->isMethod('post')) {
            return view('front.school.district.index', ['check_url'=>route('front.school.district.search'), 'topic'=>!empty($keyword)? $keyword: '']);
        }
        $list = $this->getList($keyword);
        $code = !empty($list)? 1: 0;
        $this->getJsonTool()->customJson(['code'=>$code, 'result'=>$list]);
    }

    protected function getList($keyword)
    {
        $keyword = trim($keyword);
        if (!empty($keyword)) {
            $list = [];
            $schools = School::where('name', 'like', "%{$keyword}%")->where('is_show', 1)->select(['name', 'address', 'telent', 'property'])->get();
            foreach ($schools as $item) {
                $district = $item->district;
                list($lng, $lat) = MapTool::getAddressPosition($item->address);
                $districtName = '';
                if (!empty($district)) {
                    $districtName = $district->name;
                }
                $unit = [
                    'name'      =>  $item->name,
                    'address'   =>  $item->address,
                    'telent'    =>  $item->telent,
                    'district'  =>  $districtName,
                    'lng'       =>  $lng,
                    'lat'       =>  $lat,
                    'property'  =>  '',
                ];
                if ($item->property > 0) {
                    switch ($item->property) {
                        case 1:
                            $unit['property'] = '公立';
                            break;
                        case 2:
                            $unit['property'] = '私立';
                            break;
                    }
                }
                $list[] = $unit;
            }
            return $list;
        }
        return [];
    }
}
