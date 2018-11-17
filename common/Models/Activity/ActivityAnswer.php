<?php

namespace Common\Models\Activity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivityAnswer extends Model
{
    use SoftDeletes;

    protected $table = "activity_answers";
    protected $appends = ['edit_url', 'operate_list'];

    public function getEditUrlAttribute()
    {
        return array_get($this->attributes, 'edit_url', '');
    }

    public function getOperateListAttribute()
    {
        return array_get($this->attributes, 'operate_list', []);
    }

    public function votes()
    {
        return $this->hasMany(ActivityVote::class, 'answer_id');
    }
}
