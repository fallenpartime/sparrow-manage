<?php

namespace Common\Models\Activity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use SoftDeletes;

    protected $table = "activities";
    protected $appends = ['open_status', 'edit_url', 'show_url', 'operate_list'];

    public function getOpenStatusAttribute()
    {
        return array_get($this->attributes, 'open_status', '');
    }

    public function getEditUrlAttribute()
    {
        return array_get($this->attributes, 'edit_url', '');
    }

    public function getShowUrlAttribute()
    {
        return array_get($this->attributes, 'show_url', '');
    }

    public function getOperateListAttribute()
    {
        return array_get($this->attributes, 'operate_list', []);
    }

    public function picture()
    {
        return $this->hasOne(ActivityPicture::class)->where('type', '=', 1);
    }
}
