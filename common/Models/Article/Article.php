<?php

namespace Common\Models\Article;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;

    protected $table = "articles";
    protected $appends = ['edit_url', 'show_url', 'operate_list'];

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
        return $this->hasOne(ArticlePicture::class)->where('type', '=', 1);
    }
}
