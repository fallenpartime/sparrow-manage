<?php
/**
 * 学区
 * Date: 2018/10/4
 * Time: 16:15
 */
namespace Admin\Services\School\Processor;

use Common\Models\School\SchoolDistrict;
use Frameworks\Services\Basic\Processor\BaseProcessor;

class SchoolDistrictProcessor extends BaseProcessor
{
    protected $tableName = 'school_districts';
    protected $tableClass = SchoolDistrict::class;

    public function getSingleByNo($no, $columns = [])
    {
        if (empty($no)) {
            return '';
        }
        $where = ['no' => $no];
        return $this->getSingle($where, $columns);
    }
}