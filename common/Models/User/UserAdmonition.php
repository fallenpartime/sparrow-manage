<?php

namespace Common\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAdmonition extends Model
{
    use SoftDeletes;

    protected $table = "user_admonitions";
    protected $appends = ['operate_list'];

    public function getOperateListAttribute()
    {
        return array_get($this->attributes, 'operate_list', []);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
