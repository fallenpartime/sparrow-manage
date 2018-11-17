<?php

namespace Common\Models\System;

use Illuminate\Database\Eloquent\Model;

class AdminUserGroup extends Model
{
    protected $table = "admin_user_groups";
    protected $appends = ['edit_url'];

    public function getEditUrlAttribute()
    {
        return array_get($this->attributes, 'edit_url', '');
    }
}
