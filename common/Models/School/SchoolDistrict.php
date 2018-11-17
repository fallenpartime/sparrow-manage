<?php

namespace Common\Models\School;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchoolDistrict extends Model
{
    use SoftDeletes;

    protected $table = "school_districts";
    protected $appends = ['edit_url', 'operate_list'];

    public function getEditUrlAttribute()
    {
        return array_get($this->attributes, 'edit_url', '');
    }

    public function getOperateListAttribute()
    {
        return array_get($this->attributes, 'operate_list', []);
    }

    public function schools()
    {
        return $this->hasMany(School::class, 'district_no', 'no');
    }
}
