<?php
/**
 * 后台系统权限
 */
namespace Common\Models\System;

use Illuminate\Database\Eloquent\Model;

class AdminAction extends Model
{
    protected $table = "admin_actions";
    protected $appends = ['edit_url', 'is_checked'];

    public function getEditUrlAttribute()
    {
        return array_get($this->attributes, 'edit_url', '');
    }

    public function getIsCheckedAttribute()
    {
        return array_get($this->attributes, 'is_checked', 0);
    }
}
