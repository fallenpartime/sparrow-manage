<?php

namespace Common\Models\Activity;

use Common\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivityVote extends Model
{
    use SoftDeletes;

    protected $table = "activity_votes";
    protected $appends = ['edit_url', 'operate_list'];

    public function getEditUrlAttribute()
    {
        return array_get($this->attributes, 'edit_url', '');
    }

    public function getOperateListAttribute()
    {
        return array_get($this->attributes, 'operate_list', []);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function question()
    {
        return $this->belongsTo(ActivityQuestion::class, 'question_id');
    }

    public function answer()
    {
        return $this->belongsTo(ActivityAnswer::class, 'answer_id');
    }
}
