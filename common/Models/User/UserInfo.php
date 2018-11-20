<?php

namespace Common\Models\User;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    protected $table = "user_infos";

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
