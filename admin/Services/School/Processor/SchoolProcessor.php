<?php
/**
 * 学校
 * Date: 2018/10/4
 * Time: 16:15
 */
namespace Admin\Services\School\Processor;

use Common\Models\School\School;
use Frameworks\Services\Basic\Processor\BaseProcessor;

class SchoolProcessor extends BaseProcessor
{
    protected $tableName = 'schools';
    protected $tableClass = School::class;

    public function getSingleByNo($no, $columns = [])
    {
        if (empty($no)) {
            return '';
        }
        $where = ['no' => $no];
        return $this->getSingle($where, $columns);
    }
}